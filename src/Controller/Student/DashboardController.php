<?php
declare(strict_types=1);

namespace App\Controller\Student;

use App\Model\Field\AdscriptionStatus;
use Cake\View\CellTrait;

/**
 * Stages Controller
 *
 * @property \App\Model\Table\StudentStagesTable $StudentStages
 */
class DashboardController extends AppStudentController
{
    use CellTrait;

    /**
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->StudentStages = $this->fetchTable('StudentStages');
        $this->AppUsers = $this->fetchTable('AppUsers');
        $this->Students = $this->fetchTable('Students');
    }

    /**
     * Index method
     *
     * @return void Renders view
     */
    public function index(): void
    {
        $student_id = $this->getCurrentStudent()->id;
        $studentStages = $this->StudentStages
            ->find('objectList', options: ['keyField' => 'stage'])
            ->where(['student_id' => $student_id])
            ->toArray();

        $student = $this->Students->find('loadProgress', options: ['studentStages' => $studentStages])
            ->where(['Students.id' => $student_id])
            ->find('withAppUsers')
            ->find('withTenants')
            ->find(
                'withStudentAdscriptions',
                options: [
                    'status' => AdscriptionStatus::getTrackablesValues(),
                ]
            )
            ->find('withStudentCourses')
            ->find('withStudentData')
            // /remove

            ->first();

        $listStages = $student->getStageFieldList();

        $this->set(compact('student', 'listStages', 'studentStages'));
    }
}
