<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

class AppAdminController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Authorization.Authorization');
        $this->loadComponent('CakeLte.MenuLte');
        $this->viewBuilder()->setLayout('CakeLte.default');
    }
}
