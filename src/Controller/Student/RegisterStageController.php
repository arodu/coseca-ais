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
        $studentStage = $this->Students->StudentStages->getByStudentStage($currentStudent->id, StageField::REGISTER);
        $registerStage = $studentStage->getStageInstance();

        if (empty($studentStage) || $studentStage->getStatus() !== StageStatus::IN_PROGRESS) {
            $this->Flash->warning(__('El Registro no esta activo para realizar cambios'));
            return $this->redirect(['_name' => 'student:home']);
        }
     
        $student = $registerStage->getStudent(true);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $student = $this->Students->patchEntity($student, $this->request->getData());

            if ($this->Students->save($student)) {
                $registerStage->close(StageStatus::SUCCESS);
                $this->Flash->success(__('The student has been saved.'));

                return $this->redirect(['_name' => 'student:home']);
            }
            $this->Flash->error(__('The student could not be saved. Please, try again.'));
        }

        $this->set(compact('student'));
    }
}
