<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Utility\Stages;

class AppAdminController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('CakeLte.MenuLte');
        $this->viewBuilder()->setLayout('CakeLte.default');
    }
}
