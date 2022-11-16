<?php
declare(strict_types=1);

namespace App\Controller\Student;

use App\Enum\StageField;
use App\Utility\Stages;

/**
 * Stages Controller
 *
 * @property \App\Model\Table\StudentStagesTable $StudentStages
 * @method \App\Model\Entity\Stage[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
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
        $listStages = StageField::casesByStudentType($student->type);

        $studentStagesResult = $this->StudentStages->find()
            ->where(['student_id' => $student->id]);

        $studentStages = [];
        foreach ($studentStagesResult as $studenStage) {
            $studentStages[$studenStage->stage->value] = $studenStage;
        }

        $this->set(compact('listStages', 'student', 'studentStages'));
    }
}
