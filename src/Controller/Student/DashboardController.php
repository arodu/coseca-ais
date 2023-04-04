<?php

declare(strict_types=1);

namespace App\Controller\Student;

use App\Model\Entity\Student;
use App\Model\Field\AdscriptionStatus;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Utility\Stages;
use Cake\Log\Log;
use Cake\View\CellTrait;

/**
 * Stages Controller
 *
 * @property \App\Model\Table\StudentStagesTable $StudentStages
 */
class DashboardController extends AppStudentController
{
    use CellTrait;

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

    public function register()
    {
        $currentStudent = $this->getCurrentStudent();
        /** @var \App\Model\Entity\StudentStage $registerStage */
        $registerStage = $this->Students->StudentStages
            ->find('byStudentStage', [
                'student_id' => $currentStudent->id,
                'stage' => StageField::REGISTER,
            ])
            ->first();

        if (empty($registerStage) || $registerStage->status_obj !== StageStatus::IN_PROGRESS) {
            $this->Flash->warning(__('El Registro no esta activo para realizar cambios'));
            return $this->redirect(['_name' => 'student:home']);
        }

        $student = $this->Students->get($currentStudent->id, [
            'contain' => ['Tenants', 'AppUsers', 'StudentData'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $student = $this->Students->patchEntity($student, $this->request->getData());

            try {
                $this->Students->getConnection()->begin();
                $this->Students->saveOrFail($student);
                $this->Students->StudentStages->updateStatus($registerStage, StageStatus::REVIEW);
                $this->Students->getConnection()->commit();
                $this->Flash->success(__('The student has been saved.'));

                return $this->redirect(['_name' => 'student:home']);
            } catch (\Exception $e) {
                $this->Students->getConnection()->rollback();
                Log::error($e->getMessage());
                $this->Flash->error(__('The student could not be saved. Please, try again.'));
            }
        }

        $interestAreas = $this->Students->StudentData->InterestAreas->find('list', ['limit' => 200])
            ->where(['InterestAreas.program_id' => $student->tenant->program_id])
            ->all();

        $this->set(compact('student', 'interestAreas'));
    }

    public function tracking()
    {
        $student_id = $this->getCurrentStudent()->id;
        $trackingView = $this->cell('TrackingView', ['student_id' => $student_id]);
        $this->set(compact('student_id', 'trackingView'));
    }

}
