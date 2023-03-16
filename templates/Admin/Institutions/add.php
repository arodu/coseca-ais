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



$this->Form->addWidget(
    'dependentSelector',
    ['App\View\Widget\DependentSelectorWidget', '_view']
);

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

        <?= $this->Form->control('state_id', [
            'options' => $states,
            'target' => '#municipality-id',
            'empty' => true,
        ]) ?>
        <?= $this->Form->control('municipality_id', [
            'id' => 'municipality-id',
            'target' => '#parish-id',
            'options' => [],
            'empty' => true,
            'data-url' => $this->Url->build(['action' => 'getMunicipalities']),
        ]) ?>
        <?= $this->Form->control('parish_id', [
            'id' => 'parish-id',
            'empty' => true,
            'options' => [],
            'data-url' => $this->Url->build(['action' => 'getParishes']),
        ]) ?>
    </div>

    <div class="card-footer d-flex">
        <div class="ml-auto">
            <?= $this->Form->button(__('Save')) ?>
            <?= $this->Html->link(__('Cancel'), ['action' => 'index', 'prefix' => 'Admin'], ['class' => 'btn btn-default']) ?>

        </div>
    </div>

    <?= $this->Form->end() ?>
</div>