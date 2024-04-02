<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tenant $tenant
 */
?>
<?php
$this->assign('title', __('Edit Tenant'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Programas'), 'url' => ['controller' => 'Tenants', 'action' => 'index']],
    ['title' => __('Ver'), 'url' => ['action' => 'view', $tenant->id]],
    ['title' => __('Editar')],
]);
?>

<div class="card card-primary card-outline">
    <?= $this->Form->create($tenant) ?>
    <div class="card-body">
        <?= $this->Form->control('program', [
            'label' => __('Programa'),
            'value' => $tenant->program->name,
            'readonly' => true,
        ]) ?>
        <?= $this->Form->control('location_id', [
            'label' => __('Ubicación'),
            'options' => $locations,
            'empty' => true,
            'required' => true,
        ]) ?>
        <?= $this->Form->control('active', ['label' => __('Activo'), 'custom' => true, 'checked' => true]) ?>
    </div>

    <div class="card-footer d-flex">
        <div class="">
            <?= $this->Form->postLink(
                __('Eliminar'),
                ['action' => 'delete', $tenant->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $tenant->id), 'class' => 'btn btn-danger']
            ) ?>
        </div>
        <div class="ml-auto">
            <?= $this->Form->button(__('Guardar')) ?>
            <?= $this->Html->link(__('Cancelar'), ['action' => 'view', $tenant->id], ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <?= $this->Form->end() ?>
</div>