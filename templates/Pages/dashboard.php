<?php
$this->assign('title', __('Dashboard'));
$this->Breadcrumbs->add([
    ['title' => 'Home'],
]);

$this->MenuLte->activeItem('startPages.activePage');
