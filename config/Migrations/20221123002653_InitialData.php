<?php

declare(strict_types=1);

use App\Model\Field\ProgramArea;
use App\Model\Field\TenantRegime;
use Cake\ORM\Locator\LocatorAwareTrait;
use Migrations\AbstractMigration;

class InitialData extends AbstractMigration
{
    use LocatorAwareTrait;

    public function up()
    {
        $this->saveData('Programs', [
            [
                'id' => 1,
                'name' => 'Informática',
                'area' => ProgramArea::AIS->value,
                'regime' => TenantRegime::BIANNUAL->value,
                'abbr' => 'INF',
            ]
        ]);

        $this->saveData('Tenants', [
            [
                'id' => 1,
                'program_id' => 1,
                'name' => 'San Juan',
                'abbr' => 'SJM',
                'active' => true,
            ],
            [
                'id' => 2,
                'program_id' => 1,
                'name' => 'Mellado',
                'abbr' => 'MEL',
                'active' => true,
            ],
            [
                'id' => 3,
                'program_id' => 1,
                'name' => 'Ortíz',
                'abbr' => 'ORT',
                'active' => true,
            ],
            [
                'id' => 4,
                'program_id' => 1,
                'name' => 'Calabozo',
                'abbr' => 'CAL',
                'active' => true,
            ],
        ]);

        $this->saveData('Lapses', [
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
        ]);
    }

    public function down()
    {
        $this->table('lapses')->truncate();
        $this->table('tenants')->truncate();
        $this->table('programs')->truncate();
    }


    protected function saveData(string $modelName, array $data = [])
    {
        $table = $this->fetchTable($modelName);
        $entities = $table->newEntities($data);
        return $table->saveManyOrFail($entities);
    }
}
