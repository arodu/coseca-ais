<?php

declare(strict_types=1);

use Cake\Utility\Text;

/**
 * Instituciones + `institution_projects` del demo, con geografía coherente
 * (tomada de `sys_*`) y contactos con formato realista.
 */
class InstitutionSeed extends DemoSeedBase
{
    /**
     * @return void
     */
    public function run(): void
    {
        $targets = $this->profile()['targets'];
        $lexicon = $this->data('institutions');
        $projectTemplates = $this->data('projects');

        $areas = $this->fetchTable('InterestAreas')
            ->find()
            ->select(['id', 'name'])
            ->where(['program_id' => 1])
            ->disableHydration()
            ->all()
            ->toArray();
        $areaNameById = array_column($areas, 'name', 'id');
        $areaIds = array_column($areas, 'id');

        $geo = $this->geography();
        $used = [];
        $usedProjectNames = [];

        foreach ($targets['institutions_per_tenant'] as $tenantId => $count) {
            for ($i = 0; $i < $count; $i++) {
                $name = $this->institutionName($lexicon, $used);

                $institution = $this->fetchTable('Institutions')->saveOrFail(
                    $this->fetchTable('Institutions')->newEntity([
                        'name' => $name,
                        'active' => true,
                        'contact_person' => $this->faker->firstName() . ' ' . $this->faker->lastName()
                            . ' (' . $this->faker->randomElement($lexicon['contact_roles']) . ')',
                        'contact_phone' => $this->phone(),
                        'contact_email' => $this->emailFor($name),
                        'tenant_id' => $tenantId,
                        'state_id' => $geo['state_id'],
                        'municipality_id' => $geo['municipality_id'],
                        'parish_id' => $geo['parish_id'],
                    ]),
                );

                $this->projects($institution->id, $targets, $projectTemplates, $areaIds, $areaNameById, $usedProjectNames);
            }
        }
    }

    /**
     * Crea los proyectos de una institución (~91% con `interest_area_id`).
     *
     * @param int $institutionId Institución.
     * @param array $targets Targets del profile.
     * @param array $templates Plantillas por área.
     * @param array<int, int> $areaIds Ids de área válidos.
     * @param array<int, string> $areaNameById Mapa id => nombre.
     * @param array<string, bool> $usedProjectNames Nombres ya usados (por referencia).
     * @return void
     */
    private function projects(
        int $institutionId,
        array $targets,
        array $templates,
        array $areaIds,
        array $areaNameById,
        array &$usedProjectNames,
    ): void {
        $range = $targets['projects_per_institution'];
        $count = $this->faker->numberBetween($range['min'], $range['max']);

        for ($p = 0; $p < $count; $p++) {
            $hasArea = $this->faker->randomFloat(4, 0, 1) <= $targets['projects_with_interest_area_ratio'];
            $areaId = $hasArea ? $this->faker->randomElement($areaIds) : null;
            $areaName = $areaId !== null ? $areaNameById[$areaId] : null;

            $this->fetchTable('InstitutionProjects')->saveOrFail(
                $this->fetchTable('InstitutionProjects')->newEntity([
                    'institution_id' => $institutionId,
                    'name' => $this->projectName($templates[$areaName] ?? $templates['_default'], $templates, $usedProjectNames),
                    'active' => true,
                    'interest_area_id' => $areaId,
                ]),
            );
        }
    }

    /**
     * Nombre de proyecto único (global en el demo). Prioriza las plantillas del
     * área; si se agotan, usa cualquiera libre y, en último caso, un sufijo.
     *
     * @param array<int, string> $pool Plantillas del área.
     * @param array $all Todas las plantillas por área.
     * @param array<string, bool> $used Nombres usados (por referencia).
     * @return string
     */
    private function projectName(array $pool, array $all, array &$used): string
    {
        $candidates = array_values(array_diff(array_unique($pool), array_keys($used)));
        if ($candidates === []) {
            $allTemplates = array_values(array_unique(array_merge(...array_values($all))));
            $candidates = array_values(array_diff($allTemplates, array_keys($used)));
        }

        if ($candidates === []) {
            $base = $this->faker->randomElement($pool);
            $n = 2;
            $name = $base . ' (' . $n . ')';
            while (isset($used[$name])) {
                $n++;
                $name = $base . ' (' . $n . ')';
            }
            $used[$name] = true;

            return $name;
        }

        $name = $this->faker->randomElement($candidates);
        $used[$name] = true;

        return $name;
    }

    /**
     * Nombre verosímil y único (prefijo + prócer o topónimo).
     *
     * @param array $lexicon Léxico.
     * @param array<string, bool> $used Nombres ya usados (por referencia).
     * @return string
     */
    private function institutionName(array $lexicon, array &$used): string
    {
        for ($attempt = 0; $attempt < 30; $attempt++) {
            $suffix = $this->faker->boolean(60)
                ? $this->faker->randomElement($lexicon['eponyms'])
                : $this->faker->randomElement($lexicon['toponyms']);
            $name = $this->faker->randomElement($lexicon['prefixes']) . ' ' . $suffix;
            if (!isset($used[$name])) {
                $used[$name] = true;

                return $name;
            }
        }

        return $name;
    }

    /**
     * Geografía real (parish -> municipality -> state) tomada de `sys_*`.
     *
     * @return array{state_id: int, municipality_id: int, parish_id: int}
     */
    private function geography(): array
    {
        $parishes = $this->fetchTable('System.Parishes')
            ->find()
            ->select(['id', 'municipality_id'])
            ->disableHydration()
            ->all()
            ->toArray();
        $stateByMunicipality = array_column(
            $this->fetchTable('System.Municipalities')
                ->find()
                ->select(['id', 'state_id'])
                ->disableHydration()
                ->all()
                ->toArray(),
            'state_id',
            'id',
        );

        $parish = $this->faker->randomElement($parishes);

        return [
            'state_id' => (int)$stateByMunicipality[$parish['municipality_id']],
            'municipality_id' => (int)$parish['municipality_id'],
            'parish_id' => (int)$parish['id'],
        ];
    }

    /**
     * Teléfono venezolano (11 dígitos).
     *
     * @return string
     */
    private function phone(): string
    {
        return '04' . $this->faker->numerify('#########');
    }

    /**
     * Email institucional derivado del nombre.
     *
     * @param string $name Nombre de la institución.
     * @return string
     */
    private function emailFor(string $name): string
    {
        $slug = substr(Text::slug(strtolower($name), ''), 0, 24);
        $domain = $this->weighted(['gmail.com' => 6, 'hotmail.com' => 2, 'unerg.edu.ve' => 1]);

        return $slug . '@' . $domain;
    }
}
