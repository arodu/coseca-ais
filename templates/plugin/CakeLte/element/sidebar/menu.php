<?php

use App\Model\Field\UserRole;
use CakeDC\Users\Model\Entity\User;

$menu = [];
$menu['home'] = [
    'label' => __('Inicio'),
    'icon' => 'fas fa-poll',
    'uri' => '/',
];

if (in_array($this->Identity->get('role'), UserRole::getGroup(UserRole::GROUP_STAFF))) {
    $menu['students'] = [
        'label' => __('Estudiantes'),
        'icon' => 'fas fa-address-book',
        'uri' => ['_name' => 'admin:student:index'],
    ];

    $menu['tenants'] = [
        'label' => __('Programas'),
        'icon' => 'fas fa-sitemap',
        'uri' => ['controller' => 'Tenants', 'action' => 'index', 'prefix' => 'Admin'],
    ];

    $menu['institutions'] = [
        'label' => __('Instituciones'),
        'icon' => 'fas fa-university',
        'uri' => ['controller' => 'Institutions', 'action' => 'index', 'prefix' => 'Admin'],
    ];

    $menu['tutors'] = [
        'label' => __('Tutores'),
        'icon' => 'fas fa-user-tie',
        'uri' => ['controller' => 'Tutors', 'action' => 'index', 'prefix' => 'Admin'],
    ];

    $menu['reports'] = [
        'label' => __('Reportes'),
        'uri' => ['controller' => 'Reports', 'action' => 'index', 'prefix' => 'Admin'],
    ];
}

if (in_array($this->Identity->get('role'), UserRole::getGroup(UserRole::GROUP_ADMIN))) {
    $menu['users'] = [
        'label' => __('Usuarios'),
        'icon' => 'fas fa-users',
        'uri' => ['controller' => 'AppUsers', 'action' => 'index', 'prefix' => 'Admin'],
    ];
}

$menu['logout'] = [
    'label' => __('Cerrar Sesion'),
    'icon' => 'fas fa-sign-out-alt',
    'uri' => '/logout',
];

echo $this->MenuLte->render($menu);
