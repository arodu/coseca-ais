<?php
declare(strict_types=1);

namespace App\Controller\Admin\Stage;

use App\Controller\Admin\AppAdminController;
use App\Controller\Traits\ActionValidateTrait;
use App\Controller\Traits\Stage\RegisterProcessTrait;

/**
 * Register Controller
 *
 * @method \App\Model\Entity\Student[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RegisterController extends AppAdminController
{
    use ActionValidateTrait;
    use RegisterProcessTrait;

    /**
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->Students = $this->fetchTable('Students');
    }

    /**
     * Edit method
     *
     * @param null $student_id Register Stage id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($student_id = null)
    {
        [
            'success' => $success,
            'student' => $student,
        ] = $this->processEdit((int)$student_id, ['validate' => $this->actionValidate()]);

        if ($success) {
            return $this->redirect(['_name' => 'admin:student:view', $student_id]);
        }

        $this->set(compact('student'));
    }
}
