<?php

declare(strict_types=1);

namespace App\Controller\Student;

use App\Model\Entity\Student;
use App\Model\Field\AdscriptionStatus;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Utility\Stages;

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
        $this->Students = $this->fetchTable('Students');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $student_id = $this->getCurrentStudent()->id;
        $studentStages = $this->StudentStages
            ->find('objectList', ['keyField' => 'stage'])
            ->where(['student_id' => $student_id])
            ->toArray();

        $student = $this->Students->find('loadProgress', ['studentStages' => $studentStages])
            ->where(['Students.id' => $student_id])

            // @todo remove
            ->find('withAppUsers')
            ->find('withTenants')
            ->find('withStudentAdscriptions', [
                'status' => AdscriptionStatus::getTrackablesValues(),
            ])
            ->find('withStudentCourses')
            ->find('withStudentData')
            // /remove

            ->first();

        $listStages = $student->getStageFieldList();

        $this->set(compact('student', 'listStages', 'studentStages'));
    }
}
