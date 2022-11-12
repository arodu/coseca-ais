<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Student $student
 */

use App\Model\Field\Students;

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

        <div class="row">
            <div class="col">
                <?= $this->Form->control('app_user.first_name', [
                    'label' => __('Nombres'),
                    'required' => true,
                ]) ?>
            </div>
            <div class="col">
                <?= $this->Form->control('app_user.last_name', [
                    'label' => __('Apellidos'),
                    'required' => true,
                ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <?= $this->Form->control('dni', [
                    'label' => __('Cedula'),
                    'required' => true,
                ]); ?>
            </div>
            <div class="col">
                <?= $this->Form->control('gender', [
                    'label' => __('Genero'),
                    'required' => true,
                    'options' => Students::getGenders(),
                    'empty' => true,
                ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <?= $this->Form->control('phone', [
                    'label' => __('Telefono'),
                    'required' => true,
                ]) ?>
            </div>
            <div class="col">
                <?= $this->Form->control('address', [
                    'label' => __('Dirección'),
                    'required' => true,
                ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <?= $this->Form->control('current_semester', [
                    'label' => __('Semestre Actual'),
                    'required' => true,
                    'options' => Students::getSemesters(),
                    'empty' => true,
                ]) ?>
            </div>
            <div class="col">
                <?= $this->Form->control('uc', [
                    'label' => __('Número de unidades de crédito aprobadas'),
                    'required' => true,
                    'type' => 'number',
                    'steps' => '1',
                ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <?= $this->Form->control('areas', [
                    'label' => __('Área de interés y/o potencialidades de índole tecnológico donde aspira ejercer el servicio comunitario'),
                    'required' => true,
                ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <?= $this->Form->control('observations', [
                    'label' => __('Observaciones'),
                    'required' => false,
                ]) ?>
            </div>
        </div>
    </div>

    <div class="card-footer d-flex">
        <div class="ml-auto">
            <?= $this->Form->button(__('Guardar'), ['class' => 'btn btn-primary']) ?>
            <?= $this->Html->link(__('Cancel'), ['controller' => 'Stages', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <?= $this->Form->end() ?>
</div>
