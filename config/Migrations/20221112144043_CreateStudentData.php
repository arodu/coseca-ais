<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateStudentData extends AbstractMigration
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
        $table = $this->table('student_data');
        $table->addColumn('student_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('gender', 'string', [
            'default' => null,
            'limit' => 1,
            'null' => true,
        ]);
        $table->addColumn('phone', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('address', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('current_semester', 'integer', [
            'default' => null,
            'limit' => 2,
            'null' => true,
        ]);
        $table->addColumn('uc', 'integer', [
            'default' => null,
            'limit' => 3,
            'null' => true,
        ]);
        $table->addColumn('areas', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('observations', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->create();
    }
}
