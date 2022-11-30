<?php
declare(strict_types=1);

namespace App\Controller\Student;

/**
 * Stages Controller
 *
 * @property \App\Model\Table\StudentStagesTable $StudentStages
 */
class StagesController extends AppStudentController
{

    public function initialize(): void
    {
        parent::initialize();
        $this->StudentStages = $this->fetchTable('StudentStages');
        $this->AppUsers = $this->fetchTable('AppUsers');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $student = $this->getCurrentStudent();
        $listStages = $student->getType()->getStageFieldList();

        $studentStages = $this->StudentStages
            ->find('objectList', ['keyField' => 'stage'])
            ->where(['student_id' => $student->id])
            ->toArray();

        $this->set(compact('listStages', 'student', 'studentStages'));
    }
}
