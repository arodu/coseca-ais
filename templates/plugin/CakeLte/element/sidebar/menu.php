<?php

use App\Model\Field\UserRole;

$menu = [];
$menu['home'] = [
    'label' => __('Inicio'),
    'uri' => '/',
];

if (in_array($this->Identity->get('role'), UserRole::getAdminGroup())) {
    $menu['students'] = [
        'label' => __('Estudiantes'),
        'uri' => ['controller' => 'Students', 'action' => 'index', 'prefix' => 'Admin'],
    ];

    $menu['tenants'] = [
        'label' => __('Programas'),
        'uri' => ['controller' => 'Tenants', 'action' => 'index', 'prefix' => 'Admin'],
    ];
    //$menu['lapses'] = [
    //    'label' => __('Lapsos Academicos'),
    //    'uri' => ['controller' => 'Lapses', 'action' => 'index', 'prefix' => 'Admin'],
    //];
}

if (in_array($this->Identity->get('role'), UserRole::getSuperAdminGroup())) {
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
