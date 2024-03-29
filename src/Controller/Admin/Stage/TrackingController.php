<?php
declare(strict_types=1);

namespace App\Controller\Admin\Stage;

use App\Controller\Admin\AppAdminController;
use App\Controller\Traits\Stage\TrackingProcessTrait;

/**
 * StudentTracking Controller
 *
 * @property \App\Model\Table\StudentTrackingTable $StudentTracking
 * @method \App\Model\Entity\StudentTracking[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TrackingController extends AppAdminController
{
    use TrackingProcessTrait;

    /**
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->Students = $this->fetchTable('Students');
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
            'adscription' => $adscription,
        ] = $this->processAdd($this->request->getData());

        return $this->redirect(['_name' => 'admin:student:tracking', $adscription->student_id]);
    }

    /**
     * Delete method
     *
     * @param null $tracking_id Student Tracking id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($tracking_id)
    {
        $this->request->allowMethod(['post', 'delete']);

        [
            'adscription' => $adscription,
        ] = $this->processDelete((int)$tracking_id);

        return $this->redirect(['_name' => 'admin:student:tracking', $adscription->student_id]);
    }

    /**
     * @param int|string|null $student_id
     * @return \Cake\Http\Response|null|void
     */
    public function closeStage($student_id = null)
    {
        $this->processCloseStage((int)$student_id);

        return $this->redirect(['_name' => 'admin:student:view', $student_id]);
    }

    /**
     * @param int|string|null $student_id
     * @return \Cake\Http\Response|null|void
     */
    public function validateStage($student_id = null)
    {
        $this->processValidateStage((int)$student_id);

        return $this->redirect(['_name' => 'admin:student:view', $student_id]);
    }
}
