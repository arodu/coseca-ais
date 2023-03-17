<?php

use App\Enum\Gender;
use App\Utility\Students;
use Cake\Core\Configure;

?>
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
        <?= $this->Form->control('student_data.gender', [
            'label' => __('Genero'),
            'required' => true,
            'options' => Gender::toListLabel(),
            'empty' => true,
        ]) ?>
    </div>
</div>

<div class="row">
    <div class="col">
        <?= $this->Form->control('student_data.phone', [
            'label' => __('Telefono'),
            'required' => true,
        ]) ?>
    </div>
    <div class="col">
        <?= $this->Form->control('student_data.address', [
            'label' => __('Dirección'),
            'required' => true,
        ]) ?>
    </div>
</div>

<div class="row">
    <div class="col">
        <?= $this->Form->control('student_data.current_semester', [
            'label' => __('Semestre Actual'),
            'required' => true,
            'options' => Students::getLeves($student->tenant),
            'empty' => true,
        ]) ?>
    </div>
    <div class="col">
        <?= $this->Form->control('student_data.uc', [
            'label' => __('Número de unidades de crédito aprobadas'),
            'required' => true,
            'type' => 'number',
            'steps' => '1',
            'min' => Configure::read('coseca.uc-min'),
        ]) ?>
    </div>
</div>

<div class="row">
    <div class="col">
        <?= $this->Form->control('student_data.interest_area_id', [
            'label' => __('Área de interés y/o potencialidades de índole tecnológico donde aspira ejercer el servicio comunitario'),
            'required' => true,
            'options' => $interestAreas,
            'empty' => true,
        ]) ?>
    </div>
</div>

<div class="row">
    <div class="col">
        <?= $this->Form->control('student_data.observations', [
            'label' => __('Observaciones'),
            'required' => false,
        ]) ?>
    </div>
</div>