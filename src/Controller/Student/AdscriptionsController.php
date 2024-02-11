<?php
declare(strict_types=1);

namespace App\Controller\Student;

use App\Controller\Traits\Stage\AdscriptionsProcessTrait;
use App\Model\Field\AdscriptionStatus;

/**
 * StudentTracking Controller
 *
 * @method \App\Model\Entity\StudentTracking[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 * @property \App\Model\Table\StudentsTable $Students
 * @property \App\Model\Table\StudentTrackingTable $Tracking
 */
class AdscriptionsController extends AppStudentController
{
    use AdscriptionsProcessTrait;

    public function close()
    {
        $this->request->allowMethod(['post', 'put']);

        $adscription = $this->processChangeStatus(AdscriptionStatus::CLOSED->value, $this->getRequest()->getData('student_adscription_id'));

        return $this->redirect(['_name' => 'student:tracking']);
    }
}
