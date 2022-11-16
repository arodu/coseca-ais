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
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $student = $this->getCurrentStudent();
        $listStages = $student->getType()->getStageList();

        $studentStagesResult = $this->StudentStages->find()
            ->where(['student_id' => $student->id]);

        $studentStages = [];
        foreach ($studentStagesResult as $studenStage) {
            $studentStages[$studenStage->getStageField()->value] = $studenStage;
        }

        $this->set(compact('listStages', 'student', 'studentStages'));
    }
}
