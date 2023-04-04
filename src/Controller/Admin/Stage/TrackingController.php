<?php
declare(strict_types=1);

namespace App\Controller\Admin\Stage;

use App\Controller\Admin\AppAdminController;
use App\Controller\Traits\TrackingHandleTrait;

/**
 * StudentTracking Controller
 *
 * @property \App\Model\Table\StudentTrackingTable $StudentTracking
 * @method \App\Model\Entity\StudentTracking[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TrackingController extends AppAdminController
{
    use TrackingHandleTrait;

    public function initialize(): void
    {
        parent::initialize();
        $this->Tracking = $this->fetchTable('StudentTracking');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->request->allowMethod(['post']);

        [
            'success' => $success,
            'adscription' => $adscription,
            'tracking' => $tracking,
        ] = $this->handleAdd($this->request->getData());
        
        return $this->redirect(['_name' => 'admin:student:tracking', $adscription->student_id]);
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
        $adscription = $studentTracking->student_adscription;

        if (!$this->Authorization->can($adscription, 'deleteTracking')) {
            $this->Flash->error(__('You are not authorized to delete this student tracking.'));
            return $this->redirect(['_name' => 'admin:student:tracking', $adscription->student_id]);
        }

        if ($this->StudentTracking->delete($studentTracking)) {
            $this->Flash->success(__('The student tracking has been deleted.'));
        } else {
            $this->Flash->error(__('The student tracking could not be deleted. Please, try again.'));
        }

        return $this->redirect(['_name' => 'admin:student:tracking', $adscription->student_id]);
    }
}
