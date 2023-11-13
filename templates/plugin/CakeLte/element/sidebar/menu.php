<?php

use App\Model\Field\UserRole;

$menu = [];
$menu['home'] = [
    'label' => __('Inicio'),
    'uri' => '/',
];

if (in_array($this->Identity->get('role'), UserRole::getGroup(UserRole::GROUP_ADMIN))) {
    $menu['students'] = [
        'label' => __('Estudiantes'),
        'uri' => ['_name' => 'admin:student:index'],
    ];

    $menu['tenants'] = [
        'label' => __('Programas'),
        'uri' => ['controller' => 'Tenants', 'action' => 'index', 'prefix' => 'Admin', 'plugin' => false],
    ];

    $menu['institutions'] = [
        'label' => __('Instituciones'),
        'uri' => ['controller' => 'Institutions', 'action' => 'index', 'prefix' => 'Admin'],
    ];

    $menu['tutors'] = [
        'label' => __('Tutores'),
        'uri' => ['controller' => 'Tutors', 'action' => 'index', 'prefix' => 'Admin'],
    ];
}

if (in_array($this->Identity->get('role'), UserRole::getGroup(UserRole::GROUP_ROOT))) {
    $menu['users'] = [
        'label' => __('Usuarios'),
        'uri' => ['controller' => 'AppUsers', 'action' => 'index', 'prefix' => 'Admin'],
    ];
}

$menu['logout'] = [
    'label' => __('Cerrar Sesion'),
    'uri' => '/logout',
];

echo $this->MenuLte->render($menu);
