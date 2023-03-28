<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InstitutionProject $institutionProject
 */
?>
<?php
$this->assign('title', __('Agregar Proyecto'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Instituciones'), 'url' => ['action' => 'index']],
    ['title' => h($institution->name), 'url' => ['action' => 'view', $institution->id]],
    ['title' => __('Agregar Proyecto')],
]);
?>

<div class="card card-primary card-outline">
    <?= $this->Form->create($institutionProject) ?>
    <div class="card-body">
        <?php
        echo $this->Form->control('institution', ['value' => $institution->name, 'readonly' => true]);
        echo $this->Form->control('name');
        echo $this->Form->control('interest_area_id', ['options' => $interestAreas, 'empty' => true]);
        echo $this->Form->control('active', ['custom' => true, 'checked' => true]);
        ?>
    </div>

    <div class="card-footer d-flex">
        <div class="ml-auto">
            <?= $this->Form->button(__('Guardar')) ?>
            <?= $this->Html->link(__('Cancelar'), ['action' => 'view', $institution->id], ['class' => 'btn btn-default']) ?>

        </div>
    </div>

    <?= $this->Form->end() ?>
</div>