<?php
declare(strict_types=1);

namespace App\Controller\Student;

use App\Controller\Traits\Stage\RegisterProcessTrait;

/**
 * Stages Controller
 *
 * @property \App\Model\Table\StudentStagesTable $StudentStages
 */
class RegisterController extends AppStudentController
{
    use RegisterProcessTrait;

    /**
     * @var \App\Model\Table\AppUsersTable
     */
    protected $AppUsers;

    /**
     * @var \App\Model\Table\StudentsTable
     */

    protected $Students;

    /**
     * @var \App\Model\Table\StudentStagesTable
     */
    protected $StudentStages;

    /**
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->StudentStages = $this->fetchTable('StudentStages');
        $this->AppUsers = $this->fetchTable('AppUsers');
        $this->Students = $this->fetchTable('Students');
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function edit()
    {
        $currentStudent = $this->getCurrentStudent();

        [
            'success' => $success,
            'student' => $student,
        ] = $this->processEdit($currentStudent->id, ['updateStatus' => true]);

        if ($success) {
            return $this->redirect(['_name' => 'student:home']);
        }

        $this->set(compact('student'));
    }
}
