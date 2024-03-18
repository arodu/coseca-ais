<?php

declare(strict_types=1);

use App\Model\Field\ProgramRegime;
use Migrations\AbstractSeed;

/**
 * InitialData seed.
 */
class InitialDataSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run(): void
    {
        $this->venezuela();
        $this->areas();
        $this->programs();
        $this->locations();
        $this->tenants();
    }

    public function venezuela()
    {
        if ($this->table('sys_parishes')->exists()) {
            $this->table('sys_parishes')->truncate();
        }

        if ($this->table('sys_municipalities')->exists()) {
            $this->table('sys_municipalities')->truncate();
        }

        if ($this->table('sys_cities')->exists()) {
            $this->table('sys_cities')->truncate();
        }

        if ($this->table('sys_states')->exists()) {
            $this->table('sys_states')->truncate();
        }

        $this->execute(file_get_contents(CONFIG . 'Seeds/raw/venezuela.sql'));
    }

    public function areas()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Área de Ingeniería en Informática',
                'abbr' => 'AIS',
            ],
        ];

        $table = $this->table('areas');
        $table->insert($data)->save();
    }

    public function programs()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Informática',
                'regime' => ProgramRegime::BIANNUAL->value,
                'abbr' => 'INF',
                'area_id' => 1,
            ]
        ];

        $table = $this->table('programs');
        $table->insert($data)->save();
    }

    public function locations()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'San Juan',
                'abbr' => 'SJM',
            ],
            [
                'id' => 2,
                'name' => 'Mellado',
                'abbr' => 'MEL',
            ],
            [
                'id' => 3,
                'name' => 'Ortíz',
                'abbr' => 'ORT',
            ],
            [
                'id' => 4,
                'name' => 'Calabozo',
                'abbr' => 'CAL',
            ],
        ];

        $table = $this->table('locations');
        $table->insert($data)->save();
    }

    public function tenants()
    {
        $data = [
            [
                'id' => 1,
                'program_id' => 1,
                'location_id' => 1,
                'active' => true,
            ],
            [
                'id' => 2,
                'program_id' => 1,
                'location_id' => 2,
                'active' => true,
            ],
            [
                'id' => 3,
                'program_id' => 1,
                'location_id' => 3,
                'active' => true,
            ],
            [
                'id' => 4,
                'program_id' => 1,
                'location_id' => 4,
                'active' => true,
            ],
        ];

        $table = $this->table('tenants');
        $table->insert($data)->save();
    }

    public function lapses()
    {
        $data = [
            [
                'id' => 1,
                'name' => '2023-1',
                'tenant_id' => 1,
                'active' => true,
            ],
            [
                'id' => 2,
                'name' => '2023-1',
                'tenant_id' => 2,
                'active' => true,
            ],
            [
                'id' => 3,
                'name' => '2023-1',
                'tenant_id' => 3,
                'active' => true,
            ],
            [
                'id' => 4,
                'name' => '2023-1',
                'tenant_id' => 4,
                'active' => true,
            ],
        ];

        $table = $this->table('lapses');
        $table->insert($data)->save();
    }

    public function interestAreas()
    {
        $data = [
            [
                'id' => 1,
                'program_id' => 1,
                'name' => 'Desarrollo de Software',
                'active' => true,
            ],
            [
                'id' => 2,
                'program_id' => 1,
                'name' => 'Redes y Telecomunicaciones',
                'active' => true,
            ],
            [
                'id' => 3,
                'program_id' => 1,
                'name' => 'Seguridad Informática',
                'active' => true,
            ],
        ];

        $table = $this->table('interest_areas');
        $table->insert($data)->save();
    }
}
