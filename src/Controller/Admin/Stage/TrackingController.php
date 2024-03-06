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
     * @var \App\Model\Table\StudentsTable
     */
    protected $Students;

    /**
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->Students = $this->fetchTable('Students');
    }

    /**
     * @return \Cake\Http\Response|null
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
     * @return \Cake\Http\Response|null
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
     * @param string|int|null $student_id
     * @return \Cake\Http\Response|null
     */
    public function closeStage(int|string|null $student_id = null)
    {
        $this->processCloseStage((int)$student_id);

        return $this->redirect(['_name' => 'admin:student:view', $student_id]);
    }

    /**
     * @param string|int|null $student_id
     * @return \Cake\Http\Response|null
     */
    public function validateStage(int|string|null $student_id = null)
    {
        $this->processValidateStage((int)$student_id);

        return $this->redirect(['_name' => 'admin:student:view', $student_id]);
    }
}
