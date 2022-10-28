<?php
declare(strict_types=1);

namespace App\Controller\Student;

use App\Controller\AppController;

class AppStudentController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('CakeLte.top-nav');
    }
}