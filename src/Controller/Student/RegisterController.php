<?php
declare(strict_types=1);

namespace App\Controller\Student;

use App\Controller\Traits\Stage\RegisterProcessTrait;
use Cake\Http\Response;

/**
 * Stages Controller
 *
 * @property \App\Model\Table\StudentStagesTable $StudentStages
 */
class RegisterController extends AppStudentController
{
    use RegisterProcessTrait;

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
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function edit(): Response|null|null
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
