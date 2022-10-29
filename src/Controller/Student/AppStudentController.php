<?php
declare(strict_types=1);

namespace App\Controller\Student;

use App\Controller\AppController;
use App\Model\Entity\Student;
use Cake\Cache\Cache;

class AppStudentController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');
        $this->viewBuilder()->setLayout('CakeLte.top-nav');
    }


    public function getCurrentStudent($reset = false): ?Student
    {
        $user_id = $this->Authentication->getIdentity()->getIdentifier();

        return Cache::remember('student-user-' . $user_id, function() use ($user_id) {
            return $this->fetchTable('Students')
                ->find('complete')
                ->where([
                    'user_id' => $user_id
                ])
                ->first();
        });
    }
}
