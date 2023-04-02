<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Institution $institution
 */
?>
<?php
$this->assign('title', __('Edit Institution'));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Institutions'), 'url' => ['action' => 'index', 'prefix' => 'Admin']],
    ['title' => __('View'), 'url' => ['action' => 'view', $institution->id, 'prefix' => 'Admin']],
    ['title' => __('Edit')],
]);
?>

<div class="card card-primary card-outline">
    <?= $this->Form->create($institution) ?>
    <div class="card-body">
        <?= $this->Form->control('name') ?>
        <?= $this->Form->control('active', ['custom' => true]) ?>
        <?= $this->Form->control('contact_person') ?>
        <?= $this->Form->control('contact_phone') ?>
        <?= $this->Form->control('contact_email') ?>
        <?= $this->Form->control('tenant_id', ['options' => $tenants]) ?>
        <?= $this->DependentSelector->control('state_id', [
            'options' => $states ?? [],
            'data-target' => '#municipality-select',
        ]) ?>
        <?= $this->DependentSelector->control('municipality_id', [
            'id' => 'municipality-select',
            'options' => $municipalities ?? [],
            'data-target' => '#parish-select',
            'data-url' => $this->Url->build(['action' => 'getList', 'SysMunicipalities', 'state_id']),
        ]) ?>
        <?= $this->DependentSelector->control('parish_id', [
            'id' => 'parish-select',
            'options' => $parishes  ?? [],
            'data-url' => $this->Url->build(['action' => 'getList', 'SysParishes', 'municipality_id']),
        ]) ?>
    </div>

    <div class="card-footer d-flex">
        <div></div>
        <div class="ml-auto">
            <?= $this->Form->button(__('Guardar')) ?>
            <?= $this->Html->link(__('Cancelar'), ['action' => 'view', $institution->id, 'prefix' => 'Admin'], ['class' => 'btn btn-default']) ?>

        </div>
    </div>

    <?= $this->Form->end() ?>
</div>

<?= $this->DependentSelector->script() ?>