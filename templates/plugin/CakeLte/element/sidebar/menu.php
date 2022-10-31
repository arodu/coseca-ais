<?php

use App\Model\Field\Users;

$menu = [];
$menu['home'] = [
    'label' => __('Inicio'),
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

if (in_array($this->Identity->get('role'), [Users::ROLE_ADMIN, Users::ROLE_SUPERUSER])) {
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