<?php
declare(strict_types=1);

namespace App\View\Cell;

use App\Model\Entity\Student;
use Cake\View\Cell;

/**
 * Forms cell
 */
class FormsCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array<string, mixed>
     */
    protected array $_validCellOptions = [];

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize(): void
    {
    }

    /**
     * @param \App\Model\Entity\Student $student
     * @return void
     */
    public function register(Student $student): void
    {
        $interestAreas = $this->fetchTable('InterestAreas')->find('list', limit: 200)
            ->where(['InterestAreas.program_id' => $student->tenant->program_id])
            ->all();

        $this->set(compact('student', 'interestAreas'));
    }
}
