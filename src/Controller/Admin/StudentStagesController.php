<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Model\Field\StageStatus;
use Cake\ORM\Exception\PersistenceFailedException;
use Throwable;

/**
 * StudentStages Controller
 *
 * @property \App\Model\Table\StudentStagesTable $StudentStages
 * @method \App\Model\Entity\StudentStage[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StudentStagesController extends AppAdminController
{
    /**
     * @param string|null $id StudentStage id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        $studentStage = $this->StudentStages->get($id, contain: ['Students']);
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
     * @param string|null $id StudentStage id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function forcedClose(?string $id = null)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
        $studentStage = $this->StudentStages->get($id);
        try {
            $this->StudentStages->close($studentStage, StageStatus::SUCCESS, true);
            $this->Flash->success(__('Etapa cerrada con exito: <strong>{0}</strong>', $studentStage->stage_label), ['escape' => false]);
        } catch (PersistenceFailedException $e) {
            $this->Flash->success(__('Etapa cerrada con exito: <strong>{0}</strong>', $studentStage->stage_label), ['escape' => false]);
            $this->Flash->warning(__('Siguiente etapa no creada'));
        } catch (Throwable $th) {
            $this->Flash->danger($th->getMessage());
        }

        return $this->redirect(['controller' => 'Students', 'action' => 'view', $studentStage->student_id]);
    }
}
