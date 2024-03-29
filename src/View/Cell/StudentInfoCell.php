<?php
declare(strict_types=1);

namespace App\View\Cell;

use App\Model\Entity\Student;
use App\Utility\CacheRequest;
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
     * @param int|string $student_id
     * @return void
     */
    public function display(int|string $student_id)
    {
        $student = $this->getStudent($student_id);
        $this->set(compact('student'));
    }

    /**
     * @param int|string $student_id
     * @param string|null $activeItem
     * @return void
     */
    public function menu(int|string $student_id, ?string $activeItem = null)
    {
        $student = $this->getStudent($student_id);

        $student_menu = [
            'general' => [
                'url' => ['controller' => 'Students', 'action' => 'view', $student->id, 'prefix' => 'Admin'],
                'label' => __('General'),
            ],
            'info' => [
                'url' => ['controller' => 'Students', 'action' => 'info', $student->id, 'prefix' => 'Admin'],
                'label' => __('Info'),
            ],
            'adscriptions' => [
                'url' => ['controller' => 'Students', 'action' => 'adscriptions', $student->id, 'prefix' => 'Admin'],
                'label' => __('Proyectos'),
            ],
            'tracking' => [
                'url' => ['controller' => 'Students', 'action' => 'tracking', $student->id, 'prefix' => 'Admin'],
                'label' => __('Seguimiento'),
            ],
            'settings' => [
                'url' => ['controller' => 'Students', 'action' => 'settings', $student->id, 'prefix' => 'Admin'],
                'label' => __('Configuración'),
            ],
        ];

        $this->set(compact('student_menu', 'activeItem'));
    }

    /**
     * @param int|string $student_id
     * @return \App\Model\Entity\Student|null
     */
    protected function getStudent(int|string $student_id): ?Student
    {
        return CacheRequest::remember('student_info_' . $student_id, function () use ($student_id) {
            return $this->Students->get($student_id, [
                'contain' => [
                    'AppUsers',
                    'Tenants',
                    'Lapses',
                    'LastStage',
                ],
            ]);
        });
    }
}
