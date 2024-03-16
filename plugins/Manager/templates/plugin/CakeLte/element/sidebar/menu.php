<?php

use App\Model\Field\UserRole;

$menu = [];
$menu['home'] = [
    'label' => __('Inicio'),
    'uri' => ['_name' => 'manager:home'],
];


$menu['logout'] = [
    'label' => __('Cerrar Sesion'),
    'uri' => '/logout',
];

echo $this->MenuLte->render($menu);
