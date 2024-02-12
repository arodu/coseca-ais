<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Model\Field\StageStatus;

/**
 * StudentStages Controller
 *
 * @property \App\Model\Table\StudentStagesTable $StudentStages
 * @method \App\Model\Entity\StudentStage[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StudentStagesController extends AppAdminController
{
    /**
     * Edit method
     *
     * @param string|null $id StudentStage id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $studentStage = $this->StudentStages->get($id, [
            'contain' => ['Students'],
        ]);
        $student = $studentStage->student;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $studentStage = $this->StudentStages->patchEntity($studentStage, $this->request->getData());
            if ($this->StudentStages->save($studentStage)) {
                $this->Flash->success(__('The student stage has been saved.'));

                return $this->redirect(['controller' => 'Students', 'action' => 'view', $studentStage->student_id]);
            }
            $this->Flash->error(__('The student stage could not be saved. Please, try again.'));
        }
        $this->set(compact('studentStage', 'student'));
    }

    /**
     * forcedClose method
     *
     * @param string|null $id StudentStage id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function forcedClose($id = null)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
        $studentStage = $this->StudentStages->get($id);
        try {
            $this->StudentStages->close($studentStage, StageStatus::SUCCESS, true);
            $this->Flash->success(__('Etapa cerrada con exito: <strong>{0}</strong>', $studentStage->stage_label), ['escape' => false]);
        } catch (\Cake\ORM\Exception\PersistenceFailedException $e) {
            $this->Flash->success(__('Etapa cerrada con exito: <strong>{0}</strong>', $studentStage->stage_label), ['escape' => false]);
            $this->Flash->warning(__('Siguiente etapa no creada'));
        } catch (\Throwable $th) {
            $this->Flash->danger($th->getMessage());
        }

        return $this->redirect(['controller' => 'Students', 'action' => 'view', $studentStage->student_id]);
    }
}
