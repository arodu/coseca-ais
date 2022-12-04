<?php
$this->assign('title', __('Dashboard'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio')],
]);

$this->MenuLte->activeItem('startPages.activePage');
