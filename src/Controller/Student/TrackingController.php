<?php
declare(strict_types=1);

namespace App\Controller\Student;

use App\Controller\Traits\Stage\TrackingProcessTrait;
use Cake\View\CellTrait;

/**
 * StudentTracking Controller
 *
 * @method \App\Model\Entity\StudentTracking[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 * 
 * @property \App\Model\Table\StudentsTable $Students
 * @property \App\Model\Table\StudentTrackingTable $Tracking
 */
class TrackingController extends AppStudentController
{
    use TrackingProcessTrait;
    use CellTrait;


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
    public function index()
    {
        $student_id = $this->getCurrentStudent()->id;
        $trackingView = $this->cell('TrackingView', ['student_id' => $student_id]);
        $this->set(compact('student_id', 'trackingView'));
    }

    public function add()
    {
        $this->request->allowMethod(['post']);

        [
            'success' => $success,
            'adscription' => $adscription,
            'tracking' => $tracking,
        ] = $this->processAdd($this->request->getData());
        
        return $this->redirect(['_name' => 'admin:student:tracking', $adscription->student_id]);
    }
}
