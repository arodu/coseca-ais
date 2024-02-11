<?php
declare(strict_types=1);

namespace App\View\Cell;

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
     * Default display method.
     *
     * @return void
     */
    public function display($student_id)
    {
        $student = $this->getStudent($student_id);
        $this->set(compact('student'));
    }

    public function menu(int $student_id, $activeItem = null)
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
            //'prints' => [
            //    'url' => ['controller' => 'Students', 'action' => 'prints', $student->id, 'prefix' => 'Admin'],
            //    'label' => __('Planillas'),
            //],
            'settings' => [
                'url' => ['controller' => 'Students', 'action' => 'settings', $student->id, 'prefix' => 'Admin'],
                'label' => __('Configuración'),
            ],
        ];

        $this->set(compact('student_menu', 'activeItem'));
    }

    protected function getStudent($student_id)
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
