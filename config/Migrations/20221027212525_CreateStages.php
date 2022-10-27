<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateStages extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('stages');
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('position', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('active', 'boolean', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('code', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addIndex([
            'code',
            ], [
            'name' => 'BY_CODE',
            'unique' => false,
        ]);
        $table->create();
    }
}
