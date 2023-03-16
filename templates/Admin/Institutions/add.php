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
        <?= $this->Form->control('active', ['custom' => true, 'checked' => true]) ?>
        <?= $this->Form->control('contact_person') ?>
        <?= $this->Form->control('contact_phone') ?>
        <?= $this->Form->control('contact_email') ?>
        <?= $this->Form->control('tenant_id', ['options' => $tenants, 'empty' => true]) ?>
        <?= $this->Form->control('state_id', [
            'options' => $states,
            'empty' => true,
            'class' => 'select-dependent',
            'data-target' => '#municipality-select',
        ]) ?>
        <?= $this->Form->control('municipality_id', [
            'id' => 'municipality-select',
            'options' => [],
            'empty' => true,
            'class' => 'select-dependent',
            'data-target' => '#parish-select',
            'data-url' => $this->Url->build(['action' => 'getMunicipalities']),
        ]) ?>
        <?= $this->Form->control('parish_id', [
            'id' => 'parish-select',
            'empty' => true,
            'options' => [],
            'data-url' => $this->Url->build(['action' => 'getParishes']),
        ]) ?>
    </div>

    <div class="card-footer d-flex">
        <div class="ml-auto">
            <?= $this->Form->button(__('Guardar')) ?>
            <?= $this->Html->link(__('Cancelar'), ['action' => 'index', 'prefix' => 'Admin'], ['class' => 'btn btn-default']) ?>

        </div>
    </div>

    <?= $this->Form->end() ?>
</div>

<?= $this->App->selectDependentScript('.select-dependent') ?>