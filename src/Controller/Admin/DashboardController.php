<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Cake\Event\EventInterface;

/**
 * Dashboard Controller
 */
class DashboardController extends AppAdminController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Tenants = $this->fetchTable('Tenants');
    }

    public function beforeRender(EventInterface $event)
    {
        $this->MenuLte->activeItem('home');
    }

    public function index()
    {
        $activeTenants = $this->Tenants->find('active')
            ->contain([
                'CurrentLapse',
                'Programs'
            ]);


        $this->set(compact('activeTenants'));
    }
}
