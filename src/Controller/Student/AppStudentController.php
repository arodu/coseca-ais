<?php
declare(strict_types=1);

namespace App\Controller\Student;

use App\Controller\AppController;

class AppStudentController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');
        $this->viewBuilder()->setLayout('CakeLte.top-nav');
    }


    public function getCurrentStudent($reset = false)
    {
        $identity = $this->Authentication->getIdentity();

        if ($reset || empty($identity->student)) {
            $user = $identity->getOriginalData();
            $this->fetchTable('Users')->loadInto($user, ['Students']);
            $this->Authentication->setIdentity($user);
        }

        return $identity->student;
    }
}
