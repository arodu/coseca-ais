<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Lapse $lapse
 */
$tenant = $lapse->tenant;
?>
<?php
$this->assign('title', __('Edita Lapso Académico'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Programas'), 'url' => ['controller' => 'Tenants', 'action' => 'index']],
    ['title' => __('Ver'), 'url' => ['controller' => 'Tenants', 'action' => 'view', $tenant->id, '?' => ['lapse_id' => $lapse->id]]],
    ['title' => __('Editar Lapso')],
]);
?>

<div class="card card-primary card-outline">
    <?= $this->Form->create($lapse) ?>
    <div class="card-body">
    <?php
        echo $this->Form->control('tenant', ['label' => __('Programa'), 'value' => $tenant->label, 'readonly' => true]);
        echo $this->Form->control('name', ['label' => __('Nombre')]);
        ?>
    </div>

    <div class="card-footer d-flex">
        <div class="">
            <?= $this->Form->postLink(
                __('Eliminar'),
                ['action' => 'delete', $lapse->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $lapse->id), 'class' => 'btn btn-danger']
            ) ?>
        </div>
        <div class="ml-auto">
            <?= $this->Form->button(__('Guardar')) ?>
            <?= $this->Html->link(__('Cancelar'), ['controller' => 'Tenants', 'action' => 'view', $tenant->id, '?' => ['lapse_id' => $lapse->id]], ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <?= $this->Form->end() ?>
</div>