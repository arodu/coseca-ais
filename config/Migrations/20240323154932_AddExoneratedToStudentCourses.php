<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class AddExoneratedToStudentCourses extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('student_courses');
        $table->addColumn('exonerated', 'boolean', [
            'default' => false,
            'null' => false,
            'after' => 'date',
        ]);
        $table->update();
    }
}
