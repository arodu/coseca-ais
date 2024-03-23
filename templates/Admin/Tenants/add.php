<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tenant $tenant
 */
?>
<?php
$this->assign('title', __('Nueva Sede'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Programas'), 'url' => ['controller' => 'Tenants', 'action' => 'index']],
    ['title' => 'Nueva Sede'],
]);
?>

<div class="card card-primary card-outline">
    <?= $this->Form->create($tenant, ['valueSources' => ['data', 'query', 'context']]) ?>
    <div class="card-body">
        <?php
        echo $this->Form->control('program', ['value' => $program->label, 'readonly' => true]);
        echo $this->Form->control('location_id',
        [
            'label' => __('Ubicación'),
            'options' => $locations,
            'empty' => true,
            'required' => true,
            'disabled' => $locationSelected,
        ]);
        echo $this->Form->control('active', ['label' => __('Activo'), 'custom' => true, 'checked' => true]);

        echo $this->Form->control('current_lapse.name', ['label' => __('Lapso Académico Actual')]);
        echo $this->Form->hidden('current_lapse.active', ['value' => true]);
        ?>
    </div>

    <div class="card-footer d-flex">
        <div>
            <?= $this->Button->save() ?>
        </div>
        <div class="ml-auto">
            <?= $this->Button->cancel(['url' => ['action' => 'viewProgram', $program->id]]) ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>