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
    }


    public function getCurrentStudent($reset = false): ?Student
    {
        $user = $this->Authentication->getIdentity()->getOriginalData();

        return Cache::remember('student-user-' . $user->id, function() use ($user) {
            return $this->fetchTable('Students')->getByUser($user);
        });
    }
}

