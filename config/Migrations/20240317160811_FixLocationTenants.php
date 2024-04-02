<?php

declare(strict_types=1);

use Cake\ORM\Locator\LocatorAwareTrait;
use Migrations\AbstractMigration;

class FixLocationTenants extends AbstractMigration
{
    use LocatorAwareTrait;

    public function up(): void
    {
        $table = $this->table('tenants');
        $table->addColumn('location_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
            'after' => 'program_id',
        ]);
        $table->addForeignKey('location_id', 'locations', 'id', ['delete' => 'SET_NULL', 'update' => 'NO_ACTION']);
        $table->update();

        $tenants = $this->fetchAll('SELECT DISTINCT abbr, name FROM tenants');

        foreach ($tenants ?? [] as $tenant) {
            $data = [
                'name' => $tenant['name'],
                'abbr' => $tenant['abbr'],
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ];
            $this->table('locations')->insert($data)->saveData();
            $location = $this->fetchRow('SELECT * FROM locations WHERE abbr = "' . $data['abbr'] . '"');
            $this->execute('UPDATE tenants SET location_id = ? WHERE abbr = ?', [$location['id'], $tenant['abbr']]);
        }

        $table = $this->table('tenants');
        $table->removeColumn('name');
        $table->removeColumn('abbr');
        $table->update();
    }

    public function down(): void
    {
        $table = $this->table('tenants');
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('abbr', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->update();
        $locations = $this->fetchAll('SELECT id, name, abbr FROM locations');

        foreach ($locations ?? [] as $location) {
            $this->execute('UPDATE tenants SET name = ?, abbr = ? WHERE location_id = ?', [$location['name'], $location['abbr'], $location['id']]);
        }

        $table = $this->table('tenants');
        $table->dropForeignKey('location_id');
        $table->removeColumn('location_id');
        $table->update();
    }
}
