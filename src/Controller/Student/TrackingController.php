<?php
declare(strict_types=1);

namespace App\Controller\Student;

use App\Controller\Traits\Stage\TrackingProcessTrait;
use Cake\Http\Response;
use Cake\View\CellTrait;

/**
 * StudentTracking Controller
 *
 * @method \App\Model\Entity\StudentTracking[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 * @property \App\Model\Table\StudentsTable $Students
 * @property \App\Model\Table\StudentTrackingTable $Tracking
 */
class TrackingController extends AppStudentController
{
    use TrackingProcessTrait;
    use CellTrait;

    /**
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->Students = $this->fetchTable('Students');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index(): Response|null|null
    {
        $student_id = $this->getCurrentStudent()->id;
        $trackingView = $this->cell('TrackingView', [
            'student_id' => $student_id,
            'urlList' => [
                'add' => ['_name' => 'student:tracking:add'],
                'delete' => ['_name' => 'student:tracking:delete'],
                'close' => ['_name' => 'student:tracking:close'],
            ],
        ]);
        $this->set(compact('student_id', 'trackingView'));
    }

    /**
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function add(): Response|null|null
    {
        $this->request->allowMethod(['post']);
        [
            'success' => $success,
            'adscription' => $adscription,
            'tracking' => $tracking,
        ] = $this->processAdd($this->request->getData());

        return $this->redirect(['_name' => 'student:tracking']);
    }

    /**
     * @param int $tracking_id
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function delete(int $tracking_id): Response|null|null
    {
        $this->request->allowMethod(['post', 'delete']);
        $this->processDelete((int)$tracking_id);

        return $this->redirect(['_name' => 'student:tracking']);
    }

    /**
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function closeStage(): Response|null|null
    {
        $student_id = $this->getCurrentStudent()->id;
        $this->processCloseStage((int)$student_id);

        return $this->redirect(['_name' => 'student:tracking']);
    }
}
