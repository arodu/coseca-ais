<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\ORM\Locator\LocatorAwareTrait;

/**
 * `bin/cake demo_validate`
 *
 * Recalcula métricas del dataset demo y las compara contra los objetivos de
 * `config/Seeds/Demo/data/profile.php` (tolerancia ±`targets.tolerance`).
 * Devuelve código 1 si alguna métrica queda fuera de tolerancia.
 */
class DemoValidateCommand extends Command
{
    use LocatorAwareTrait;

    /**
     * Piso absoluto de tolerancia: a escala demo (60 estudiantes) los ratios
     * muy chicos (≈1–2%) tienen ruido de muestreo grande; ±15% relativo sería
     * imposible de cumplir.
     */
    private const ABSOLUTE_FLOOR = 0.02;

    /**
     * @param \Cake\Console\ConsoleOptionParser $parser Parser.
     * @return \Cake\Console\ConsoleOptionParser
     */
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        return $parser->setDescription('Valida el dataset demo contra su huella objetivo.');
    }

    /**
     * @param \Cake\Console\Arguments $args Argumentos.
     * @param \Cake\Console\ConsoleIo $io IO.
     * @return int|null
     */
    public function execute(Arguments $args, ConsoleIo $io): ?int
    {
        /** @var array $profile */
        $profile = require dirname(__DIR__, 2) . '/config/Seeds/Demo/data/profile.php';
        $targets = $profile['targets'];
        $scale = $profile['scale'];
        $tol = $targets['tolerance'];

        $rows = [];
        $failures = 0;

        $add = function (string $name, $actual, $expected) use (&$rows, &$failures, $tol): void {
            $ok = $this->withinTolerance((float)$actual, (float)$expected, (float)$tol);
            $rows[] = [$name, (string)$expected, (string)$actual, $ok ? 'OK' : 'FALLA'];
            if (!$ok) {
                $failures++;
            }
        };

        // Cardinalidades
        $add('students', $this->fetchTable('Students')->find()->count(), $scale['students']);
        $add('institutions', $this->fetchTable('Institutions')->find()->count(), $scale['institutions']);
        $add('tutors', $this->fetchTable('Tutors')->find()->count(), $scale['tutors']);
        $add('tenants activos', $this->fetchTable('Tenants')->find()->where(['active' => true])->count(), $scale['tenants']);

        // Ratios de género
        $byGender = $this->groupCount('student_data', 'gender');
        $totalGender = array_sum($byGender) ?: 1;
        $add('gender F (ratio)', ($byGender['F'] ?? 0) / $totalGender, $targets['gender_ratio']['F']);

        // Proyectos con área de interés
        $projects = $this->fetchTable('InstitutionProjects')->find()->count();
        $withArea = $this->fetchTable('InstitutionProjects')->find()->where(['interest_area_id IS' => null])->count();
        $add('proyectos con área (ratio)', ($projects - $withArea) / max($projects, 1), $targets['projects_with_interest_area_ratio']);

        // Estados de adscripción
        $byStatus = $this->groupCount('student_adscriptions', 'status');
        $totalStatus = array_sum($byStatus) ?: 1;
        foreach ($targets['adscription_status_ratio'] as $name => $ratio) {
            $add("adscription {$name} (ratio)", ($byStatus[$name] ?? 0) / $totalStatus, $ratio);
        }

        // Seguimiento: horas
        $hours = $this->fetchTable('StudentTracking')
            ->find()
            ->select(['mn' => 'MIN(hours)', 'mx' => 'MAX(hours)', 'avg' => 'AVG(hours)'])
            ->disableHydration()
            ->first();
        $add('tracking horas (media)', $hours['avg'] ?? 0, $targets['tracking_hours']['mean']);
        $add('tracking horas (min)', $hours['mn'] ?? 0, $targets['tracking_hours']['min']);
        $add('tracking horas (max)', $hours['mx'] ?? 0, $targets['tracking_hours']['max']);

        // Cursos exonerados
        $courses = $this->fetchTable('StudentCourses')->find()->count();
        $exonerated = $this->fetchTable('StudentCourses')->find()->where(['exonerated' => true])->count();
        $add('cursos exonerados (ratio)', $exonerated / max($courses, 1), $targets['course_exonerated_ratio']);

        // Documentos: tipo/modelo correcto
        $doc = $targets['document'];
        $documents = $this->fetchTable('StudentDocuments')->find()->count();
        $validDocuments = $this->fetchTable('StudentDocuments')
            ->find()
            ->where(['type' => $doc['type'], 'model' => $doc['model']])
            ->count();
        $add('documentos válidos (ratio)', $validDocuments / max($documents, 1), 1.0);

        $io->helper('Table')->output(array_merge([['Métrica', 'Objetivo', 'Real', 'Estado']], $rows));

        if ($failures > 0) {
            $io->error("{$failures} métrica(s) fuera de tolerancia (±" . ($tol * 100) . '%)');

            return self::CODE_ERROR;
        }

        $io->success('Dataset demo dentro de tolerancia.');

        return self::CODE_SUCCESS;
    }

    /**
     * Cuenta filas agrupadas por una columna (`only_full_group_by`-safe).
     *
     * @param string $table Tabla.
     * @param string $column Columna de agrupación.
     * @return array<string, int>
     */
    private function groupCount(string $table, string $column): array
    {
        $rows = (array)$this->fetchTable($table)
            ->getConnection()
            ->execute("SELECT {$column} AS k, COUNT(*) AS n FROM {$table} GROUP BY {$column}")
            ->fetchAll('assoc');

        $result = [];
        foreach ($rows as $row) {
            $result[(string)$row['k']] = (int)$row['n'];
        }

        return $result;
    }

    /**
     * Compara `actual` con `expected` dentro de la tolerancia relativa.
     * Si el objetivo es 0, exige que el real también sea 0.
     *
     * @param float $actual Valor real.
     * @param float $expected Valor objetivo.
     * @param float $tolerance Tolerancia relativa.
     * @return bool
     */
    private function withinTolerance(float $actual, float $expected, float $tolerance): bool
    {
        return abs($actual - $expected) <= abs($expected) * $tolerance + self::ABSOLUTE_FLOOR;
    }
}
