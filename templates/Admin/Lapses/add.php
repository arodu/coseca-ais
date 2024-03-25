<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Lapse $lapse
 */
?>
<?php
$this->assign('title', __('Nuevo Lapso Académico'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Programas'), 'url' => ['controller' => 'Tenants', 'action' => 'index']],
    ['title' => __('Ver'), 'url' => ['controller' => 'Tenants', 'action' => 'view', $tenant->id]],
    ['title' => __('Nuevo')],
]);
?>

<div class="card card-primary card-outline">
    <?= $this->Form->create($lapse) ?>
    <div class="card-body">
        <?php
        echo $this->Form->hidden('tenant_id', ['value' => $tenant->id]);
        echo $this->Form->control('tenant', ['label' => __('Programa'), 'value' => $tenant->label, 'readonly' => true]);

        // @todo crear prototipo de nombre de nuevo lapso académico
        echo $this->Form->control('name', ['label' => __('Nombre')]);
        echo $this->Form->control('active', ['label' => __('Activo'), 'custom' => true]);
        ?>
    </div>
    <div class="card-footer d-flex">
        <div class="ml-auto">
            <?= $this->Form->button(__('Guardar')) ?>
            <?= $this->Html->link(__('Cancelar'), ['controller' => 'Tenants', 'action' => 'view', $tenant->id], ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <?= $this->Form->end() ?>
</div>