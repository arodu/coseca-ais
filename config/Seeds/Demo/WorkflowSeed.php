<?php

declare(strict_types=1);

use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;

/**
 * Pipeline completo del workflow por estudiante, respetando `config/stages.php`.
 *
 * - Aprovecha que la etapa `register` ya existe (creada por
 *   `StudentsTable::afterSave()`); para el resto usa `createOrFail`/entidades.
 * - Encadena `parent_id` y fechas cronológicas.
 * - Adscripciones siempre con `institution_project` y `tutor` del mismo tenant.
 * - No envía `lapse_id` a las adscripciones (columna eliminada).
 */
class WorkflowSeed extends DemoSeedBase
{
    /**
     * Orden del grupo `regular` (config/stages.php).
     *
     * @var array<int, string>
     */
    private const STAGES = ['register', 'course', 'adscription', 'tracking', 'results', 'ending'];

    /**
     * Estado de la etapa "actual" (abierta) por etapa.
     *
     * @var array<string, string>
     */
    private const CURRENT_STATUS = [
        'register' => 'in-progress',
        'course' => 'waiting',
        'adscription' => 'waiting',
        'tracking' => 'in-progress',
        'results' => 'in-progress',
        'ending' => 'waiting',
    ];

    /**
     * @return void
     */
    public function run(): void
    {
        $this->lapseDates();

        $windowStart = FrozenTime::now()->subMonths(10)->startOfMonth();
        $targets = $this->profile()['targets'];
        $trackingTemplates = array_merge(...array_values($this->data('tracking')));

        $projectsByTenant = $this->projectsByTenant();
        $tutorsByTenant = $this->tutorsByTenant();
        $tutorByProject = $this->tutorByProject($projectsByTenant, $tutorsByTenant);

        $students = $this->fetchTable('Students')
            ->find()
            ->select(['id', 'tenant_id', 'type'])
            ->disableHydration()
            ->all()
            ->toArray();

        // Nivel de avance por estudiante (determinista) y bolsa de estados de
        // adscripción, para que los ratios cuadren con la huella.
        $levels = [];
        foreach ($students as $student) {
            $levels[] = (int)$this->weighted($this->levelWeights());
        }
        $adscriptionCount = count(array_filter($levels, fn (int $level): bool => $level >= 2));
        $statusBag = $this->shuffledStatuses($adscriptionCount, $targets['adscription_status_ratio']);

        foreach ($students as $index => $student) {
            $level = $levels[$index];
            $this->stages($student, $level, $windowStart);

            if ($level >= 1) {
                $this->courses($student, $windowStart);
            }

            if ($level >= 2) {
                $this->adscriptions(
                    $student,
                    $level,
                    $windowStart,
                    $trackingTemplates,
                    $projectsByTenant[$student['tenant_id']] ?? [],
                    $tutorByProject,
                    array_pop($statusBag),
                );
            }
        }
    }

    /**
     * Crea los `lapse_dates` por defecto de cada lapso (InitialDataSeed insertó
     * los lapsos crudos, saltando `LapsesTable::afterSave`).
     *
     * @return void
     */
    private function lapseDates(): void
    {
        $LapseDates = $this->fetchTable('LapseDates');
        $base = FrozenDate::now()->subMonths(10)->startOfMonth();

        foreach ($this->fetchTable('Lapses')->find() as $lapse) {
            foreach ($LapseDates->defaultDatesEntities($lapse->id) as $index => $date) {
                $date->set('start_date', $base->addDays($index * 20));
                $date->set('end_date', $base->addDays($index * 20 + 15));
                $LapseDates->saveOrFail($date);
            }
        }
    }

    /**
     * Distribución de niveles de avance derivada del funnel de la huella.
     *
     * @return array<int, float>
     */
    private function levelWeights(): array
    {
        $f = $this->profile()['targets']['funnel'];

        return [
            0 => 1 - $f['register']['success'],
            1 => $f['register']['success'] - $f['course']['success'],
            2 => $f['course']['success'] - $f['adscription']['success'],
            3 => $f['adscription']['success'] - $f['tracking']['success'],
            4 => $f['tracking']['success'] - $f['results']['success'],
            5 => $f['results']['success'] - $f['ending']['success'],
            6 => $f['ending']['success'],
        ];
    }

    /**
     * Bolsa de estados de adscripción con la proporción objetivo (cuotas por
     * redondeo), mezclada de forma determinista con el Faker sembrado.
     *
     * @param int $count Cantidad de adscripciones.
     * @param array<string, float> $ratios Estado => proporción.
     * @return array<int, string>
     */
    private function shuffledStatuses(int $count, array $ratios): array
    {
        $bag = [];
        foreach ($ratios as $status => $ratio) {
            $bag = array_merge($bag, array_fill(0, (int)round($count * $ratio), $status));
        }
        while (count($bag) < $count) {
            $bag[] = (string)array_key_first($ratios);
        }
        $bag = array_slice($bag, 0, $count);

        return $this->faker->shuffle($bag);
    }

    /**
     * Encadena las etapas hasta `$level` (success las pasadas, abierta la actual).
     *
     * @param array $student Fila de estudiante.
     * @param int $level Cantidad de etapas cerradas en `success`.
     * @param \Cake\I18n\FrozenTime $windowStart Inicio del lapso.
     * @return void
     */
    private function stages(array $student, int $level, FrozenTime $windowStart): void
    {
        $StudentStages = $this->fetchTable('StudentStages');
        $cursor = $windowStart->subDays($this->faker->numberBetween(0, 15));
        $parentId = null;

        foreach (self::STAGES as $index => $stage) {
            if ($index > $level) {
                break;
            }

            $status = $index < $level ? 'success' : self::CURRENT_STATUS[$stage];
            $created = $cursor;
            $modified = $index < $level ? $created->addDays($this->faker->numberBetween(10, 40)) : $created;

            if ($stage === 'register') {
                $entity = $StudentStages->find()
                    ->where(['student_id' => $student['id'], 'stage' => 'register'])
                    ->firstOrFail();
            } else {
                $entity = $StudentStages->newEntity(['student_id' => $student['id'], 'stage' => $stage]);
            }

            $entity->set('status', $status);
            $entity->set('parent_id', $parentId);
            $entity->set('created', $created);
            $entity->set('modified', $modified);
            $StudentStages->saveOrFail($entity);

            $parentId = $entity->id;
            $cursor = $modified->addDays($this->faker->numberBetween(1, 10));
        }
    }

    /**
     * Cursos (taller) del estudiante.
     *
     * @param array $student Fila de estudiante.
     * @param \Cake\I18n\FrozenTime $windowStart Inicio del lapso.
     * @return void
     */
    private function courses(array $student, FrozenTime $windowStart): void
    {
        $count = (int)$this->weighted([1 => 96, 2 => 4]);

        for ($i = 0; $i < $count; $i++) {
            $this->fetchTable('StudentCourses')->saveOrFail(
                $this->fetchTable('StudentCourses')->newEntity([
                    'student_id' => $student['id'],
                    'date' => $windowStart->addDays($this->faker->numberBetween(20, 60)),
                    'exonerated' => $this->faker->randomFloat(4, 0, 1) <= 0.01,
                    'comment' => $this->faker->boolean(30) ? $this->faker->sentence(6) : null,
                ]),
            );
        }
    }

    /**
     * Adscripciones (+ tracking y documentos) del estudiante.
     *
     * @param array $student Fila de estudiante.
     * @param int $level Nivel de avance (para saber si llegó a seguimiento).
     * @param \Cake\I18n\FrozenTime $windowStart Inicio del lapso.
     * @param array $targets Targets del profile.
     * @param array<int, string> $trackingTemplates Plantillas de seguimiento.
     * @param array<int, int> $projectIds Proyectos del tenant.
     * @param array<int, int> $tutorByProject Mapa institution_project_id => tutor_id.
     * @param string $status Estado de la adscripción (de la bolsa por proporción).
     * @return void
     */
    private function adscriptions(
        array $student,
        int $level,
        FrozenTime $windowStart,
        array $trackingTemplates,
        array $projectIds,
        array $tutorByProject,
        string $status,
    ): void {
        if ($projectIds === []) {
            return;
        }

        // El demo usa una única adscripción por estudiante, marcada como principal.
        $projectId = $this->faker->randomElement($projectIds);
        $tutorId = $tutorByProject[$projectId] ?? null;
        if ($tutorId === null) {
            return;
        }

        $created = $windowStart->addDays($this->faker->numberBetween(35, 90));
        $modified = $created->addDays($this->faker->numberBetween(0, 60));

        $adscription = $this->fetchTable('StudentAdscriptions')->saveOrFail(
            $this->fetchTable('StudentAdscriptions')->newEntity([
                'student_id' => $student['id'],
                'institution_project_id' => $projectId,
                'tutor_id' => $tutorId,
                'status' => $status,
                'principal' => true,
            ]),
        );
        $this->fetchTable('StudentAdscriptions')->updateAll(
            ['created' => $created, 'modified' => $modified],
            ['id' => $adscription->id],
        );

        if ($level >= 3 && $status !== 'cancelled') {
            $this->tracking($adscription->id, $student['id'], $created, $targets, $trackingTemplates);
        }

        if ($status === 'closed') {
            $this->document($adscription, $student['id']);
        }
    }

    /**
     * Entradas de seguimiento de una adscripción.
     *
     * @param int $adscriptionId Adscripción.
     * @param int $studentId Estudiante.
     * @param \Cake\I18n\FrozenTime $start Inicio de la adscripción.
     * @param array $targets Targets del profile.
     * @param array<int, string> $templates Plantillas de descripción.
     * @return void
     */
    private function tracking(
        int $adscriptionId,
        int $studentId,
        FrozenTime $start,
        array $targets,
        array $templates,
    ): void {
        $range = $targets['tracking_per_adscription'];
        $count = $this->faker->numberBetween($range['min'], $range['max']);
        $cursor = $start;

        for ($i = 0; $i < $count; $i++) {
            $cursor = $cursor->addDays($this->faker->numberBetween(1, 7));
            $this->fetchTable('StudentTracking')->saveOrFail(
                $this->fetchTable('StudentTracking')->newEntity([
                    'student_adscription_id' => $adscriptionId,
                    'date' => $cursor,
                    'hours' => $this->hours($targets['tracking_hours']),
                    'description' => $this->faker->randomElement($templates),
                ]),
            );
        }
    }

    /**
     * Horas de una entrada de seguimiento: múltiplo de 0.25 (bloques de 15 min)
     * dentro de `[$min, $max]`, sesgado a la baja (u^1.7) para acercarse a la
     * media real.
     *
     * @param array $range ['min' => float, 'max' => float].
     * @return float
     */
    private function hours(array $range): float
    {
        $u = $this->faker->randomFloat(6, 0, 1);
        $minQuarters = (int)round($range['min'] * 4);
        $maxQuarters = (int)round($range['max'] * 4);
        // Sesgo a la baja para acercarse a la media real, en bloques de 15 min.
        $quarters = $minQuarters + (int)round(($maxQuarters - $minQuarters) * ($u ** 1.7));

        return $quarters / 4;
    }

    /**
     * Documento `adscription_project` de una adscripción cerrada.
     *
     * @param \App\Model\Entity\StudentAdscription $adscription Adscripción.
     * @param int $studentId Estudiante.
     * @return void
     */
    private function document($adscription, int $studentId): void
    {
        $document = $this->profile()['targets']['document'];

        $this->fetchTable('StudentDocuments')->saveOrFail(
            $this->fetchTable('StudentDocuments')->newEntity([
                'student_id' => $studentId,
                'type' => $document['type'],
                'token' => $this->faker->uuid(),
                'model' => $document['model'],
                'foreign_key' => $adscription->id,
            ]),
        );
    }

    /**
     * Asigna un tutor fijo a cada proyecto (mismo tenant), de modo que todas las
     * adscripciones a un proyecto compartan el tutor académico.
     *
     * @param array<int, array<int, int>> $projectsByTenant Proyectos por tenant.
     * @param array<int, array<int, int>> $tutorsByTenant Tutores por tenant.
     * @return array<int, int> institution_project_id => tutor_id.
     */
    private function tutorByProject(array $projectsByTenant, array $tutorsByTenant): array
    {
        $map = [];
        foreach ($projectsByTenant as $tenantId => $projectIds) {
            $tutorIds = $tutorsByTenant[$tenantId] ?? [];
            if ($tutorIds === []) {
                continue;
            }
            foreach ($projectIds as $index => $projectId) {
                $map[$projectId] = $tutorIds[$index % count($tutorIds)];
            }
        }

        return $map;
    }

    /**
     * Ids de `institution_projects` agrupados por tenant.
     *
     * @return array<int, array<int, int>>
     */
    private function projectsByTenant(): array
    {
        $rows = $this->fetchTable('InstitutionProjects')
            ->find()
            ->select(['id' => 'InstitutionProjects.id', 'tenant_id' => 'Institutions.tenant_id'])
            ->contain(['Institutions'])
            ->disableHydration()
            ->all()
            ->toArray();

        return $this->groupIds($rows);
    }

    /**
     * Ids de `tutors` agrupados por tenant.
     *
     * @return array<int, array<int, int>>
     */
    private function tutorsByTenant(): array
    {
        $rows = $this->fetchTable('Tutors')
            ->find()
            ->select(['id', 'tenant_id'])
            ->disableHydration()
            ->all()
            ->toArray();

        return $this->groupIds($rows);
    }

    /**
     * Agrupa filas `id`/`tenant_id` en `[tenant_id => [id, ...]]`.
     *
     * @param array $rows Filas.
     * @return array<int, array<int, int>>
     */
    private function groupIds(array $rows): array
    {
        $grouped = [];
        foreach ($rows as $row) {
            $grouped[(int)$row['tenant_id']][] = (int)$row['id'];
        }

        return $grouped;
    }
}
