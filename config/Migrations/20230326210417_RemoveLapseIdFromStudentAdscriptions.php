<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RemoveLapseIdFromStudentAdscriptions extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function up(): void
    {
        $table = $this->table('student_adscriptions');
        $table->removeColumn('lapse_id');
        $table->update();
    }

    public function down(): void
    {
        $table = $this->table('student_adscriptions');
        $table->addColumn('lapse_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->update();
    }
}
