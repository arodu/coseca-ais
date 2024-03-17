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
        ]);
        $table->addForeignKey('location_id', 'locations', 'id', ['delete' => 'SET_NULL', 'update' => 'NO_ACTION']);
        $table->update();

        $tenantsTable = $this->fetchTable('Tenants');
        $locationsTable = $this->fetchTable('Locations');

        $tenants = $tenantsTable
            ->find()
            ->select(['abbr', 'name'])
            ->distinct();

        foreach ($tenants as $tenant) {
            $location = $locationsTable->newEntity([
                'name' => $tenant->name,
                'abbr' => $tenant->abbr
            ]);
            $location = $locationsTable->saveOrFail($location);
            $tenantsTable->updateAll(['location_id' => $location->id], ['abbr' => $tenant->abbr]);
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

        $tenantsTable = $this->fetchTable('Tenants');
        $locationsTable = $this->fetchTable('Locations');
        
        $locations = $locationsTable->find()->select(['id', 'name', 'abbr']);
        foreach ($locations as $location) {
            $tenantsTable->updateAll(['name' => $location->name, 'abbr' => $location->abbr], ['location_id' => $location->id]);
        }

        $table = $this->table('tenants');
        $table->dropForeignKey('location_id');
        $table->removeColumn('location_id');
        $table->update();
    }
}
