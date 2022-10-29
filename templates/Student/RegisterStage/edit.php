<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Student $student
 */
?>
<?php
$this->assign('title', __('Registro de Estudiante'));
$this->Breadcrumbs->add([
    ['title' => 'Inicio', 'url' => '/'],
    ['title' => __('Registro')],
]);
?>

<div class="card card-primary card-outline">
    <?= $this->Form->create($student) ?>
    <div class="card-body">
        <?php
        echo $this->Form->control('dni', [
            'label' => __('Cedula'),
            'required' => true,
        ]);
        echo $this->Form->control('app_user.first_name', [
            'label' => __('Nombres'),
            'required' => true,
        ]);
        echo $this->Form->control('app_user.last_name', [
            'label' => __('Apellidos'),
            'required' => true,
        ]);
        ?>
    </div>

    <div class="card-footer d-flex">
        <div class="ml-auto">
            <?= $this->Form->button(__('Guardar'), ['class' => 'btn btn-primary']) ?>
            <?= $this->Html->link(__('Cancel'), ['controller' => 'Stages', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <?= $this->Form->end() ?>
</div>
