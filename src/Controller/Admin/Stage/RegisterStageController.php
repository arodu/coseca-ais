<?php
declare(strict_types=1);

namespace App\Controller\Admin\Stage;

use App\Controller\Admin\AppAdminController;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;

/**
 * RegisterStage Controller
 *
 * @method \App\Model\Entity\Student[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RegisterStageController extends AppAdminController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Students = $this->fetchTable('Students');
    }

    /**
     * Edit method
     *
     * @param string|null $id Register Stage id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($student_id = null)
    {
        $student = $this->Students->get($student_id, [
            'contain' => ['AppUsers', 'Tenants', 'StudentData'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $student = $this->Students->patchEntity($student, $this->request->getData());

            $studentStage = $this->Students->StudentStages->find('byStudentStage', [
                'stage' => StageField::REGISTER,
                'student_id' => $student->id,
            ])->first();

            if ($this->Students->save($student)) {
                $this->Flash->success(__('The register stage has been saved.'));

                $this->Students->StudentStages->close($studentStage, StageStatus::SUCCESS);

                return $this->redirect(['controller' => 'Students', 'action' => 'view', $student->id, 'prefix' => 'Admin']);
                
            }
            $this->Flash->error(__('The register stage could not be saved. Please, try again.'));
        }
        $this->set(compact('student'));
    }
}
