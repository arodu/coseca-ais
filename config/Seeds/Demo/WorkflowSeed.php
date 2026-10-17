<?php

declare(strict_types=1);

use Cake\Core\Configure;
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
     * Comentarios posibles del taller.
     *
     * @var array<int, string>
     */
    private const COMMENTS = [
        'Aprobado según la evaluación del facilitador.',
        'Cumplió con las actividades programadas del taller.',
        'Participación destacada durante el taller.',
        'Asistió y completó las prácticas del taller.',
    ];

    /**
     * Anclas temporales del demo, relativas a la fecha de ejecución.
     */
    private FrozenTime $registerDate;
    private FrozenTime $courseDate;
    private FrozenTime $adscriptionDate;
    private FrozenTime $trackingEnd;
    private FrozenTime $expoferiaDate;

    /**
     * @return void
     */
    public function run(): void
    {
        $this->initTimeline();
        $this->lapseDates();

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

        // Nivel de avance por estudiante (determinista).
        $levels = [];
        foreach ($students as $student) {
            $levels[] = (int)$this->weighted($this->levelWeights());
        }

        foreach ($students as $index => $student) {
            $level = $levels[$index];
            $this->stages($student, $level);

            if ($level >= 1) {
                $this->courses($student);
            }

            if ($level >= 2) {
                $this->adscriptions(
                    $student,
                    $level,
                    $targets,
                    $trackingTemplates,
                    $projectsByTenant[$student['tenant_id']] ?? [],
                    $tutorByProject,
                );
            }
        }
    }

    /**
     * Ancla la línea temporal del demo a la fecha de ejecución. El seguimiento
     * dura 12 semanas (8 atrás, 4 adelante) para quedar en curso; el taller una
     * semana antes de su inicio, el registro unos días antes del taller, y la
     * expoferia una semana después del fin del seguimiento.
     *
     * @return void
     */
    private function initTimeline(): void
    {
        $today = FrozenTime::now();
        $this->adscriptionDate = $today->subWeeks(8);
        $this->trackingEnd = $today->addWeeks(4);
        $this->courseDate = $this->adscriptionDate->subWeeks(1);
        $this->registerDate = $this->courseDate->subDays(10);
        $this->expoferiaDate = $this->trackingEnd->addWeeks(1);
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

        $windows = [
            'register' => [$this->registerDate->subDays(5), $this->courseDate->subDays(1)],
            'course' => [$this->courseDate, $this->courseDate],
            'tracking' => [$this->adscriptionDate, $this->trackingEnd],
            'ending' => [$this->expoferiaDate, $this->expoferiaDate],
        ];

        foreach ($this->fetchTable('Lapses')->find() as $lapse) {
            foreach ($LapseDates->defaultDatesEntities($lapse->id) as $date) {
                [$start, $end] = $windows[$date->stage];
                $date->set('start_date', $start);
                $date->set('end_date', $end);
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
     * Encadena las etapas hasta `$level` (success las pasadas, abierta la actual).
     *
     * @param array $student Fila de estudiante.
     * @param int $level Cantidad de etapas cerradas en `success`.
     * @return void
     */
    private function stages(array $student, int $level): void
    {
        $StudentStages = $this->fetchTable('StudentStages');
        $anchors = [
            'register' => $this->registerDate,
            'course' => $this->courseDate,
            'adscription' => $this->adscriptionDate,
            'tracking' => $this->adscriptionDate,
            'results' => $this->trackingEnd,
            'ending' => $this->expoferiaDate,
        ];
        $parentId = null;

        foreach (self::STAGES as $index => $stage) {
            if ($index > $level) {
                break;
            }

            $status = $index < $level ? 'success' : self::CURRENT_STATUS[$stage];
            $created = $anchors[$stage]->addDays($this->rng->intBetween(-3, 3));
            $modified = $index < $level ? $created->addDays($this->rng->intBetween(3, 10)) : $created;

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
        }
    }

    /**
     * Cursos (taller) del estudiante.
     *
     * @param array $student Fila de estudiante.
     * @return void
     */
    private function courses(array $student): void
    {
        $count = (int)$this->weighted([1 => 96, 2 => 4]);

        for ($i = 0; $i < $count; $i++) {
            $this->fetchTable('StudentCourses')->saveOrFail(
                $this->fetchTable('StudentCourses')->newEntity([
                    'student_id' => $student['id'],
                    'date' => $this->courseDate->addDays($this->rng->intBetween(-3, 3)),
                    'exonerated' => $this->rng->float(0, 1) <= 0.01,
                    'comment' => $this->rng->chance(30) ? $this->rng->pick(self::COMMENTS) : null,
                ]),
            );
        }
    }

    /**
     * Adscripciones (+ tracking y documentos) del estudiante.
     *
     * @param array $student Fila de estudiante.
     * @param int $level Nivel de avance (para saber si llegó a seguimiento).
     * @param array $targets Targets del profile.
     * @param array<int, string> $trackingTemplates Plantillas de seguimiento.
     * @param array<int, int> $projectIds Proyectos del tenant.
     * @param array<int, int> $tutorByProject Mapa institution_project_id => tutor_id.
     * @return void
     */
    private function adscriptions(
        array $student,
        int $level,
        array $targets,
        array $trackingTemplates,
        array $projectIds,
        array $tutorByProject,
    ): void {
        if ($projectIds === []) {
            return;
        }

        // El demo usa una única adscripción por estudiante, marcada como principal.
        $projectId = $this->rng->pick($projectIds);
        $tutorId = $tutorByProject[$projectId] ?? null;
        if ($tutorId === null) {
            return;
        }

        $created = $this->adscriptionDate->addDays($this->rng->intBetween(-3, 3));
        $modified = $created->addDays($this->rng->intBetween(0, 10));

        $adscription = $this->fetchTable('StudentAdscriptions')->saveOrFail(
            $this->fetchTable('StudentAdscriptions')->newEntity([
                'student_id' => $student['id'],
                'institution_project_id' => $projectId,
                'tutor_id' => $tutorId,
                'status' => 'open',
                'principal' => true,
            ]),
        );
        $this->fetchTable('StudentAdscriptions')->updateAll(
            ['created' => $created, 'modified' => $modified],
            ['id' => $adscription->id],
        );

        // Solo se cierra la adscripción si el seguimiento acumula las horas mínimas.
        $totalHours = 0.0;
        if ($level >= 3) {
            $totalHours = $this->tracking($adscription->id, $trackingTemplates, $targets['tracking_hours']);
        }

        if ($totalHours >= (float)Configure::read('coseca.hours-min')) {
            $this->fetchTable('StudentAdscriptions')->updateAll(['status' => 'closed'], ['id' => $adscription->id]);
            $this->document($adscription, $student['id']);
        }
    }

    /**
     * Entradas de seguimiento de una adscripción, repartidas desde el inicio del
     * seguimiento hasta hoy (~8 semanas), dentro de la ventana del lapso.
     *
     * @param int $adscriptionId Adscripción.
     * @param array<int, string> $templates Plantillas de descripción.
     * @param array $hoursRange Rango de horas ['min' => float, 'max' => float].
     * @return float Total de horas registradas.
     */
    private function tracking(int $adscriptionId, array $templates, array $hoursRange): float
    {
        $cursor = $this->adscriptionDate->addDays($this->rng->intBetween(0, 5));
        $today = FrozenTime::now();
        $total = 0.0;
        $guard = 0;

        while ($cursor <= $today && $guard < 60) {
            $hours = $this->hours($hoursRange);
            $total += $hours;
            $this->fetchTable('StudentTracking')->saveOrFail(
                $this->fetchTable('StudentTracking')->newEntity([
                    'student_adscription_id' => $adscriptionId,
                    'date' => $cursor,
                    'hours' => $hours,
                    'description' => $this->rng->pick($templates),
                ]),
            );
            $cursor = $cursor->addDays($this->rng->intBetween(1, 7));
            $guard++;
        }

        return $total;
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
        $u = $this->rng->float(0, 1);
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
                'token' => $this->rng->uuid(),
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
