<?php

use App\Enum\Gender;
use App\Utility\StudentLevels;
use Cake\Core\Configure;
use Cake\View\Form\EntityContext;

$this->Form->context(new EntityContext(['entity' => $student]));
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
        <?= $this->Form->control('app_user.dni', [
            'label' => __('Cédula'),
            'required' => true,
            'type' => 'number',
        ]); ?>
    </div>
    <div class="col">
        <?= $this->Form->control('student_data.gender', [
            'label' => __('Género'),
            'required' => true,
            'options' => Gender::toListLabel(),
            'empty' => true,
        ]) ?>
    </div>
</div>

<div class="row">
    <div class="col">
        <?= $this->Form->control('student_data.phone', [
            'label' => __('Teléfono'),
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
            'label' => __('{0} actual', StudentLevels::getFormLabel($student->tenant->program)),
            'required' => true,
            'options' => StudentLevels::getList($student->tenant->program),
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
            //'max' => Configure::read('coseca.uc-max'),
        ]) ?>
    </div>
</div>

<div class="row">
    <div class="col">
        <?= $this->Form->control('student_data.interest_area_id', [
            'label' => __('Área de interés y/o potencialidades'),
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