<?php
declare(strict_types=1);

namespace App\Controller\Student;

use App\Model\Field\Stages;

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
        // @todo check for multiple tenants
        $student = $this->getAuthUser()->students[0];
        $stages = Stages::getStageList($student->type);

        $studentStagesResult = $this->StudentStages->find()
            ->where(['student_id' => $student->id]);

        $studentStages = [];
        foreach ($studentStagesResult as $studenStage) {
            $studentStages[$studenStage->stage] = $studenStage;
        }

        $this->set(compact('stages', 'student', 'studentStages'));
    }
}
