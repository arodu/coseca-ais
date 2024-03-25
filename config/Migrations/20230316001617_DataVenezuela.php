<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class DataVenezuela extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('sys_states');
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('iso', 'string', [
            'default' => null,
            'limit' => 6,
            'null' => false,
        ]);
        $table->create();

        $table = $this->table('sys_cities');
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('state_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('capital', 'boolean', [
            'default' => false,
            'null' => false,
        ]);
        $table->create();

        $table = $this->table('sys_municipalities');
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('state_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->create();

        $table = $this->table('sys_parishes');
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('municipality_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->create();
    }
}
