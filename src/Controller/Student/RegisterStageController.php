<?php

declare(strict_types=1);

namespace App\Controller\Student;

use App\Model\Field\StageField;
use App\Model\Field\StageStatus;

/**
 * RegisterStage Controller
 *
 * @property \App\Model\Table\StudentsTable $Students
 */
class RegisterStageController extends AppStudentController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Students = $this->fetchTable('Students');
    }

    /**
     * Edit method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit()
    {
        $currentStudent = $this->getCurrentStudent();
        /** @var \App\Model\Entity\StudentStage $studentStage */
        $studentStage = $this->Students->StudentStages
            ->find('byStudentStage', [
                'student_id' => $currentStudent->id,
                'stage' => StageField::REGISTER,
            ])
            ->first();

        if (empty($studentStage) || $studentStage->status_obj !== StageStatus::IN_PROGRESS) {
            $this->Flash->warning(__('El Registro no esta activo para realizar cambios'));
            return $this->redirect(['_name' => 'student:home']);
        }

        $student = $this->Students->get($currentStudent->id, [
            'contain' => ['Tenants', 'AppUsers', 'StudentData'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $student = $this->Students->patchEntity($student, $this->request->getData());

            if ($this->Students->save($student)) {
                $this->Students->StudentStages->close($studentStage, StageStatus::REVIEW);
                $this->Flash->success(__('The student has been saved.'));

                return $this->redirect(['_name' => 'student:home']);
            }
            $this->Flash->error(__('The student could not be saved. Please, try again.'));
        }

        $interestAreas = $this->Students->StudentData->InterestAreas->find('list', ['limit' => 200])
            ->where(['InterestAreas.program_id' => $student->tenant->program_id])
            ->all();

        $this->set(compact('student', 'interestAreas'));
    }
}
