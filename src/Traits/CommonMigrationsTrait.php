<?php

declare(strict_types=1);

namespace App\Traits;

use Migrations\Table;

trait CommonMigrationsTrait
{
    /**
     * @param \Migrations\Table $table
     * @param array $options
     * @return \Migrations\Table
     */
    public function setAuditFields(Table $table, array $options = ['created', 'created_by', 'modified', 'modified_by', 'deleted', 'deleted_by']): Table
    {

        if (in_array('created', $options)) {
            $table = $table->addColumn('created', 'datetime', [
                'default' => null,
                'null' => false,
            ]);
        }
        if (in_array('created_by', $options)) {
            $table = $table->addColumn('created_by', 'uuid', [
                'default' => null,
                'null' => false,
            ]);
        }
        if (in_array('modified', $options)) {
            $table = $table->addColumn('modified', 'datetime', [
                'default' => null,
                'null' => false,
            ]);
        }
        if (in_array('modified_by', $options)) {
            $table = $table->addColumn('modified_by', 'uuid', [
                'default' => null,
                'null' => false,
            ]);
        }
        if (in_array('deleted', $options)) {
            $table = $table->addColumn('deleted', 'datetime', [
                'default' => null,
                'null' => false,
            ]);
        }
        if (in_array('deleted_by', $options)) {
            $table = $table->addColumn('deleted_by', 'uuid', [
                'default' => null,
                'null' => false,
            ]);
        }

        return $table;
    }
}
