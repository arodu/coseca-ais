<?php

declare(strict_types=1);

use Cake\I18n\FrozenDate;

/**
 * Catálogos del demo: enriquece las áreas de interés del programa Informática
 * (la huella real tiene 10) y fija los lapsos al período vigente.
 *
 * Asume que `InitialDataSeed` ya corrió (área, programa, 4 locations, 4 tenants
 * activos con ids 1–4, y 4 lapses base).
 */
class CatalogSeed extends DemoSeedBase
{
    /**
     * Nombres de `interest_areas` del programa Informática, tomados del léxico
     * real de producción (solo los nombres, ninguna relación con registros).
     *
     * @var array<int, string>
     */
    private const INTEREST_AREAS = [
        'Desarrollo Frontend',
        'Desarrollo Backend',
        'Mantenimiento y Soporte Técnico a Equipos Informáticos',
        'Informática Forense',
        'Educación en Tecnología Informática',
        'Marketing Digital',
        'Desarrollo de Software',
        'Redes de Telecomunicaciones y Datos',
        'Seguridad Informática',
        'Otra (Indique en las observaciones)',
    ];

    /**
     * @return void
     */
    public function run(): void
    {
        $this->interestAreas();
        $this->lapses();
    }

    /**
     * Reemplaza las áreas de interés por el set realista de Informática.
     *
     * @return void
     */
    private function interestAreas(): void
    {
        $table = $this->table('interest_areas');
        $table->truncate();

        $data = [];
        foreach (self::INTEREST_AREAS as $index => $name) {
            $data[] = [
                'id' => $index + 1,
                'program_id' => 1,
                'name' => $name,
                'description' => null,
                'active' => true,
            ];
        }

        $table->insert($data)->save();
    }

    /**
     * Renombra los lapsos base al período vigente (sin disparar `afterSave`,
     * que crearía `lapse_dates`; de eso se encarga WorkflowSeed).
     *
     * @return void
     */
    private function lapses(): void
    {
        $name = FrozenDate::now()->year . '-1';
        $this->fetchTable('Lapses')->updateAll(['name' => $name], ['tenant_id >' => 0]);
    }
}
