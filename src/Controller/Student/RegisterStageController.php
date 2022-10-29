<?php
declare(strict_types=1);

namespace App\Controller\Student;

use App\Model\Field\Stages;
use Cake\Cache\Cache;

/**
 * RegisterStage Controller
 *
 * @property \App\Model\Table\StudentsTable $Students
 * @property \App\Stage\StageInterface $Stage
 */
class RegisterStageController extends AppStudentController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Students = $this->fetchTable('Students');

        $this->Stage = $this->getCurrentStudent()->getStageInstance(Stages::STAGE_REGISTER);
    }

    /**
     * Edit method
     *
     * @param string|null $id Student id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit()
    {
        $studentStage = $this->Stage->getStudentStage();

        if ($studentStage->status !== Stages::STATUS_IN_PROGRESS) {
            $this->Flash->warning(__('El Registro no esta activo para realizar cambios'));
            $this->redirect(['controller' => 'Stages', 'action' => 'index']);
        }
     
        $student = $this->Stage->getStudent();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $student = $this->Students->patchEntity($student, $this->request->getData());

            if ($this->Students->save($student)) {
                $this->Flash->success(__('The student has been saved.'));

                // @todo eliminar esta cache en el afterSave del StudentsTable
                $user_id = $this->Authentication->getIdentity()->getIdentifier();
                Cache::delete('student-user-' . $user_id);

                $this->Stage->close(Stages::STATUS_SUCCESS);

                return $this->redirect(['controller' => 'Stages', 'action' => 'index']);
            }
            $this->Flash->error(__('The student could not be saved. Please, try again.'));
        }

        $this->set(compact('student'));
    }
}
