<?php

use App\Model\Field\Users;

$menu = [];
$menu['home'] = [
    'label' => 'Inicio',
    'uri' => '/',
];

if (in_array($this->Identity->get('role'), Users::getAdminRoles())) {

    $menu['students'] = [
        'label' => __('Estudiantes'),
        'uri' => ['controller' => 'Students', 'action' => 'index', 'prefix' => 'Admin'],
    ];

    $menu['lapses'] = [
        'label' => __('Lapsos Academicos'),
        'uri' => ['controller' => 'Lapses', 'action' => 'index', 'prefix' => 'Admin'],
    ];
}

$menu['logout'] = [
    'label' => 'Cerrar Sesion',
    'uri' => '/logout',
];

echo $this->MenuLte->render($menu);