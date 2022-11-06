<?php
declare(strict_types=1);

use App\Model\Table\LapsesTable;
use Cake\I18n\FrozenDate;
use Cake\ORM\Locator\LocatorAwareTrait;
use Migrations\AbstractMigration;

class InitialData extends AbstractMigration
{
    use LocatorAwareTrait;

    public function up()
    {
        $TenantsTable = $this->fetchTable('Tenants');
        $tenantEntities = $TenantsTable->newEntities([
            [
                'id' => 1,
                'name' => 'Infomática - San Juan',
                'abbr' => 'AIS-SJ',
                'active' => true,
            ],
            [
                'id' => 2,
                'name' => 'Infomática - Mellado',
                'abbr' => 'AIS-ME',
                'active' => true,
            ],
            [
                'id' => 3,
                'name' => 'Infomática - Ortíz',
                'abbr' => 'AIS-OT',
                'active' => true,
            ],
        ]);
        $TenantsTable->saveManyOrFail($tenantEntities);

        $LapsesTable = $this->fetchTable('Lapses');
        $lapseEntities = $LapsesTable->newEntities([
            [
                'id' => 1,
                'name' => '2022-2',
                'date' => FrozenDate::create(2022,10,17),
                'tenant_id' => 1,
                'active' => true,
            ],
            [
                'id' => 2,
                'name' => '2022-2',
                'date' => FrozenDate::create(2022,10,17),
                'tenant_id' => 2,
                'active' => true,
            ],
            [
                'id' => 3,
                'name' => '2022-2',
                'date' => FrozenDate::create(2022,10,17),
                'tenant_id' => 3,
                'active' => true,
            ],
        ]);
        $LapsesTable->saveManyOrFail($lapseEntities);
    }

    public function down()
    {
        $this->table('lapses')->truncate();
        $this->table('tenants')->truncate();
    }
}
