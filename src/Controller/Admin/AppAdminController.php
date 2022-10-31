<?php

namespace App\Controller\Admin;

use App\Controller\AppController;

class AppAdminController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');
        $this->viewBuilder()->setLayout('CakeLte.default');
    }
}
