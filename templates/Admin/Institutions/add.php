<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Institution $institution
 */
?>
<?php
$this->assign('title', __('Add Institution'));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Institutions'), 'url' => ['action' => 'index', 'prefix' => 'Admin']],
    ['title' => __('Add')],
]);
?>

<div class="card card-primary card-outline">
    <?= $this->Form->create($institution) ?>
    <div class="card-body">
        <?= $this->Form->control('name') ?>
        <?= $this->Form->control('active', ['custom' => true, 'checked' => true]) ?>
        <?= $this->Form->control('contact_person') ?>
        <?= $this->Form->control('contact_phone') ?>
        <?= $this->Form->control('contact_email', ['type' => 'email']) ?>
        <?= $this->Form->control('tenant_id', ['options' => $tenants, 'empty' => true]) ?>
        <?= $this->DependentSelector->control('state_id', [
            'options' => $states,
            'data-target' => '#municipality-select',
        ]) ?>
        <?= $this->DependentSelector->control('municipality_id', [
            'id' => 'municipality-select',
            'data-target' => '#parish-select',
            'data-url' => $this->Url->build(['action' => 'getList', 'SysMunicipalities', 'state_id']),
        ]) ?>
        <?= $this->DependentSelector->control('parish_id', [
            'id' => 'parish-select',
            'data-url' => $this->Url->build(['action' => 'getList', 'SysParishes', 'municipality_id']),
        ]) ?>
    </div>
    <div class="card-footer d-flex">
        <div>
            <?= $this->AppForm->buttonSave() ?>
        </div>
        <div class="ml-auto">
            <?= $this->AppForm->buttonCancel(['url' => ['action' => 'index', 'prefix' => 'Admin']]) ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>

<?= $this->DependentSelector->script() ?>