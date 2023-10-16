<?php

/**
 * @var \App\View\AppView $this
 */
?>
<?php
$this->assign('title', __('Dashboard'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio')],
]);
?>

<div class="row">
    <?= $this->cell('Dashboard::blocks') ?>
</div>

<div class="row">
    <div class="col-md-6">
        <?= $this->cell('Dashboard::activeTenants') ?>
        <?= $this->cell('Dashboard::events') ?>
    </div>
    <div class="col-md-6">
        <?= $this->cell('Dashboard::stages') ?>
    </div>
</div>
