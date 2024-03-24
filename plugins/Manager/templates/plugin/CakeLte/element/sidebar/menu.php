<?php

use App\Model\Field\UserRole;

$menu = [];
$menu['home'] = [
    'label' => __('Inicio'),
    'uri' => ['_name' => 'manager:home'],
];

$menu['areas'] = [
    'label' => __('Areas'),
    'uri' => ['controller' => 'Areas', 'action' => 'index'],
];

$menu['programs'] = [
    'label' => __('Programas'),
    'uri' => ['controller' => 'Programs', 'action' => 'index'],
];


$menu['locations'] = [
    'label' => __('Ubicaciones'),
    'uri' => ['controller' => 'Locations', 'action' => 'index'],
];

$menu['users'] = [
    'label' => __('Usuarios'),
    'uri' => ['controller' => 'Users', 'action' => 'index'],
];

$menu['logout'] = [
    'label' => __('Cerrar Sesion'),
    'uri' => '/logout',
];

echo $this->MenuLte->render($menu);
