<?php
declare(strict_types=1);

namespace App\Controller\Student;

use App\Model\Field\AdscriptionStatus;
use Cake\View\CellTrait;

/**
 * StudentTracking Controller
 *
 * @method \App\Model\Entity\StudentTracking[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TrackingStageController extends AppStudentController
{
    use CellTrait;


    public function initialize(): void
    {
        parent::initialize();
        $this->Students = $this->fetchTable('Students');
        $this->StudentTracking = $this->fetchTable('StudentTracking');
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
}
