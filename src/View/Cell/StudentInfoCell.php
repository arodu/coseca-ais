<?php
declare(strict_types=1);

namespace App\View\Cell;

use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\View\Cell;

/**
 * StudentInfo cell
 */
class StudentInfoCell extends Cell
{
    use LocatorAwareTrait;

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array<string, mixed>
     */
    protected $_validCellOptions = [];

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->Students = $this->fetchTable('Students');
    }

    /**
     * Default display method.
     *
     * @return void
     */
    public function display($student_id)
    {
        $student = $this->Students->get($student_id, [
            'contain' => [
                'AppUsers',
                'Tenants',
                'Lapses',
                'LastStage',
            ],
        ]);

        $this->set(compact('student'));
    }
}
