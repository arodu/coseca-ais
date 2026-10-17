<?php
declare(strict_types=1);

namespace App\Test\TestCase\Seeds;

use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\FrozenDate;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\TestSuite\ConnectionHelper;
use Cake\TestSuite\TestCase;
use Migrations\Migrations;

/**
 * Tests del seed demo (`DemoSeed`).
 *
 * Corre el seed contra la conexión `test` y valida cardinalidades, coherencia
 * referencial, funnel, documentos y determinismo.
 */
class DemoSeedTest extends TestCase
{
    use LocatorAwareTrait;

    /**
     * @var array<string, bool>
     */
    private const REGULAR_STAGES = [
        'register' => true,
        'course' => true,
        'adscription' => true,
        'tracking' => true,
        'results' => true,
        'ending' => true,
    ];

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->resetDatabase();
        $this->seed();
    }

    /**
     * @return void
     */
    public function tearDown(): void
    {
        $this->resetDatabase();
        parent::tearDown();
    }

    /**
     * @return void
     */
    public function testCardinalidadesYUnicidad(): void
    {
        $this->assertSame(60, $this->fetchTable('Students')->find()->count());
        $this->assertSame(60, $this->fetchTable('AppUsers')->find()->where(['role' => 'student'])->count());
        $this->assertSame(10, $this->fetchTable('Institutions')->find()->count());
        $this->assertSame(10, $this->fetchTable('Tutors')->find()->count());
        $this->assertSame(4, $this->fetchTable('Tenants')->find()->where(['active' => true])->count());

        // Un solo `students` row por `AppUser` (sin doble alta).
        foreach ($this->fetchTable('Students')->find()->all() as $student) {
            $count = $this->fetchTable('Students')->find()->where(['user_id' => $student->user_id])->count();
            $this->assertSame(1, $count, "AppUser {$student->user_id} tiene {$count} matrículas");
        }

        // Sin etapas duplicadas por (student_id, stage).
        $duplicates = ConnectionManager::get('test')
            ->execute('SELECT student_id, stage FROM student_stages GROUP BY student_id, stage HAVING COUNT(*) > 1')
            ->fetchAll('assoc');
        $this->assertSame([], $duplicates);
    }

    /**
     * @return void
     */
    public function testCoherenciaReferencial(): void
    {
        $adscriptions = $this->fetchTable('StudentAdscriptions')
            ->find()
            ->contain(['Students', 'Tutors', 'InstitutionProjects.Institutions'])
            ->all();

        $this->assertGreaterThan(0, $adscriptions->count());

        foreach ($adscriptions as $adscription) {
            $student = $adscription->student;
            $this->assertSame(
                $student->tenant_id,
                $adscription->tutor->tenant_id,
                'El tutor no pertenece al tenant del estudiante',
            );
            $this->assertSame(
                $student->tenant_id,
                $adscription->institution_project->institution->tenant_id,
                'El proyecto no pertenece al tenant del estudiante',
            );
        }
    }

    /**
     * @return void
     */
    public function testFunnelYFechas(): void
    {
        $stages = $this->fetchTable('StudentStages')
            ->find()
            ->order(['student_id' => 'ASC', 'id' => 'ASC'])
            ->all();

        $byStudent = [];
        foreach ($stages as $stage) {
            $this->assertArrayHasKey($stage->stage, self::REGULAR_STAGES, "Etapa inválida: {$stage->stage}");
            $this->assertLessThanOrEqual(
                $stage->modified,
                $stage->created,
                'created > modified en una etapa',
            );
            $byStudent[$stage->student_id][$stage->id] = $stage;
        }

        // Encadenamiento de parent_id dentro del mismo estudiante.
        foreach ($stages as $stage) {
            if ($stage->parent_id === null) {
                continue;
            }
            $parent = $byStudent[$stage->student_id][$stage->parent_id] ?? null;
            $this->assertNotNull($parent, 'parent_id no referencia una etapa del mismo estudiante');
            $this->assertLessThan($stage->id, $parent->id, 'parent_id no precede a la etapa');
        }

        // Todos los estudiantes tienen la etapa register.
        foreach ($this->fetchTable('Students')->find()->all() as $student) {
            $this->assertTrue(
                $this->fetchTable('StudentStages')->exists(['student_id' => $student->id, 'stage' => 'register']),
                "El estudiante {$student->id} no tiene etapa register",
            );
        }

        // Regla de negocio: el demo no llega a Resultados ni Conclusión, para no
        // activar las planillas 007/008 sin el seguimiento al 100%.
        $this->assertSame(0, $this->fetchTable('StudentStages')->find()->where(['stage IN' => ['results', 'ending']])->count());
        $this->assertSame(0, $this->fetchTable('StudentStages')->find()->where(['stage' => 'tracking', 'status IN' => ['review', 'success']])->count());

        // Horas y fechas del seguimiento.
        $today = FrozenDate::now();
        foreach ($this->fetchTable('StudentTracking')->find()->all() as $tracking) {
            $this->assertGreaterThanOrEqual(0.25, (float)$tracking->hours);
            $this->assertLessThanOrEqual(12.0, (float)$tracking->hours);
            $this->assertLessThanOrEqual($today, $tracking->date, 'Seguimiento con fecha futura');
        }
    }

    /**
     * Verifica que las horas de seguimiento sean múltiplo de 0.25 (bloques de
     * 15 min) y estén dentro de [0.25, 12].
     *
     * @return void
     */
    public function testTrackingHorasEnBloquesDe15Min(): void
    {
        $tracking = $this->fetchTable('StudentTracking')->find()->all();
        $this->assertGreaterThan(0, $tracking->count());

        foreach ($tracking as $entry) {
            $hours = (float)$entry->hours;
            $this->assertGreaterThanOrEqual(0.25, $hours, "Horas menores al mínimo: {$hours}");
            $this->assertLessThanOrEqual(12.0, $hours, "Horas mayores al máximo: {$hours}");
            $this->assertEqualsWithDelta(
                0.0,
                fmod($hours, 0.25),
                1e-9,
                "Horas {$hours} no son múltiplo de 0.25 (bloques de 15 min)",
            );
        }
    }

    /**
     * @return void
     */
    public function testDocumentos(): void
    {
        $hoursMin = (float)Configure::read('coseca.hours-min');

        foreach ($this->fetchTable('StudentDocuments')->find()->all() as $document) {
            $this->assertSame('adscription_project', $document->type);
            $this->assertSame('StudentAdscriptions', $document->model);
            $this->assertTrue(
                $this->fetchTable('StudentAdscriptions')->exists(['id' => $document->foreign_key]),
                'foreign_key no referencia una adscripción existente',
            );
        }

        // Regla de negocio: solo se cierra la adscripción con el mínimo de horas.
        $closedBelowMin = $this->fetchTable('StudentAdscriptions')
            ->find()
            ->innerJoinWith('Students')
            ->where(['StudentAdscriptions.status' => 'closed', 'Students.total_hours <' => $hoursMin])
            ->count();
        $this->assertSame(0, $closedBelowMin, 'Hay adscripciones cerradas con menos horas que el mínimo');
    }

    /**
     * @return void
     */
    public function testDeterminismo(): void
    {
        $first = $this->signature();

        $this->resetDatabase();
        $this->seed();

        $this->assertSame($first, $this->signature());
    }

    /**
     * Firma determinista del dataset (distribuciones, sin depender de ids).
     *
     * @return array
     */
    private function signature(): array
    {
        $connection = ConnectionManager::get('test');
        $count = fn (string $table): int => (int)$connection
            ->execute("SELECT COUNT(*) AS n FROM {$table}")
            ->fetch('assoc')['n'];
        $group = function (string $table, string $column) use ($connection): array {
            $rows = $connection
                ->execute("SELECT {$column} AS k, COUNT(*) AS n FROM {$table} GROUP BY {$column}")
                ->fetchAll('assoc');
            $result = [];
            foreach ($rows as $row) {
                $result[(string)$row['k']] = (int)$row['n'];
            }
            ksort($result);

            return $result;
        };

        return [
            'students_by_tenant' => $group('students', 'tenant_id'),
            'gender' => $group('student_data', 'gender'),
            'semester' => $group('student_data', 'current_semester'),
            'stages' => $group('student_stages', 'stage'),
            'adscriptions' => $count('student_adscriptions'),
            'tracking' => $count('student_tracking'),
            'documents' => $count('student_documents'),
        ];
    }

    /**
     * Trunca todas las tablas de la conexión `test` (deja la base limpia).
     *
     * @return void
     */
    private function resetDatabase(): void
    {
        $tables = array_values(array_filter(
            ConnectionManager::get('test')->getSchemaCollection()->listTables(),
            fn (string $table): bool => !str_contains($table, 'phinxlog'),
        ));

        (new ConnectionHelper())->truncateTables('test', $tables);
    }

    /**
     * @return void
     */
    private function seed(): void
    {
        (new Migrations())->seed(['connection' => 'test', 'seed' => 'DemoSeed']);
    }
}
