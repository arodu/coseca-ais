<?php
declare(strict_types=1);

namespace App\Controller\Student;

use App\Model\Field\Stages;

/**
 * Stages Controller
 *
 * @property \App\Model\Table\StagesTable $Stages
 * @method \App\Model\Entity\Stage[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StagesController extends AppStudentController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $stages = Stages::getStages();
        $student = $this->getCurrentStudent();

        $studentStagesResult = $this->fetchTable('StudentStages')
            ->find()
            ->where(['student_id' => $student->id]);

        $studentStages = [];
        foreach ($studentStagesResult as $studenStage) {
            $studentStages[$studenStage->stage] = $studenStage;
        }

        $this->set(compact('stages', 'student', 'studentStages'));
    }

}
