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
    public function initialize(): void
    {
        parent::initialize();
        $this->StudentTracking = $this->fetchTable('StudentTracking');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->request->allowMethod(['post']);
        $data = $this->request->getData();

        $adscription = $this->StudentTracking->StudentAdscriptions->get($data['student_adscription_id']);

        $tracking = $this->StudentTracking->newEntity($data);

        if ($this->StudentTracking->save($tracking)) {
            $this->Flash->success(__('The student tracking has been saved.'));
        } else {
            $this->Flash->error(__('The student tracking could not be saved. Please, try again.'));
        }
        
        return $this->redirect(['_name' => 'admin:student_tracking', $adscription->student_id]);
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
        $studentTracking = $this->StudentTracking->get($id, [
            'contain' => ['StudentAdscriptions'],
        ]);
        if ($this->StudentTracking->delete($studentTracking)) {
            $this->Flash->success(__('The student tracking has been deleted.'));
        } else {
            $this->Flash->error(__('The student tracking could not be deleted. Please, try again.'));
        }

        return $this->redirect(['_name' => 'admin:student_tracking', $studentTracking->student_adscription->student_id]);
    }
}
