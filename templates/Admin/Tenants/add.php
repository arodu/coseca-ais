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
        <?= $this->Form->control('program_id', [
            'label' => __('Programa'),
            'options' => $programs,
            'empty' => true,
            'required' => true,            
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
        <div>
            <?= $this->Button->save() ?>
        </div>
        <div class="ml-auto">
            <?php if (!empty($program_id)) : ?>
                <?= $this->Button->cancel(['url' => ['action' => 'viewProgram', $program_id]]) ?>
            <?php else : ?>
                <?= $this->Button->cancel(['url' => ['action' => 'index']]) ?>
            <?php endif; ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>