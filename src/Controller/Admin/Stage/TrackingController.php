<?php
declare(strict_types=1);

namespace App\Controller\Admin\Stage;

use App\Controller\Admin\AppAdminController;

/**
 * StudentTracking Controller
 *
 * @property \App\Model\Table\StudentTrackingTable $StudentTracking
 * @method \App\Model\Entity\StudentTracking[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TrackingController extends AppAdminController
{
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($student_id)
    {
        $studentTracking = $this->StudentTracking->newEmptyEntity();
        if ($this->request->is('post')) {
            $studentTracking = $this->StudentTracking->patchEntity($studentTracking, $this->request->getData());
            if ($this->StudentTracking->save($studentTracking)) {
                $this->Flash->success(__('The student tracking has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The student tracking could not be saved. Please, try again.'));
        }
        $studentAdscriptions = $this->StudentTracking->StudentAdscriptions->find('list', ['limit' => 200])->all();
        $this->set(compact('studentTracking', 'studentAdscriptions'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Student Tracking id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $studentTracking = $this->StudentTracking->get($id);
        if ($this->StudentTracking->delete($studentTracking)) {
            $this->Flash->success(__('The student tracking has been deleted.'));
        } else {
            $this->Flash->error(__('The student tracking could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
