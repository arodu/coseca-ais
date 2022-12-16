<?php

/**
 * @var \App\View\AppView $this
 */

use App\Enum\Gender;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Utility\Students;

$this->student_id = $student->id;
$this->active = null;
$this->extend('/Admin/Common/view_student');

$this->assign('title', __('Estudiante'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Estudiantes'), 'url' => ['controller' => 'Students', 'action' => 'index']],
    ['title' => __('Ver'), 'url' => ['controller' => 'Students', 'action' => 'view', $student->id]],
    ['title' => StageField::REGISTER->label()],
    ['title' => __('Editar')],
]);
?>

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
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <?= $this->Form->control('student_data.areas', [
                'label' => __('Área de interés y/o potencialidades de índole tecnológico donde aspira ejercer el servicio comunitario'),
                'required' => true,
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
</div>
</div>

<div class="card-footer d-flex">
    <div>
    </div>
    <div class="ml-auto">
        <?= $this->Form->button(__('Guardar')) ?>
        <?= $this->Html->link(__('Cancelar'), ['controller' => 'Students', 'action' => 'view', $student->id], ['class' => 'btn btn-default']) ?>
    </div>
</div>
<?= $this->Form->end() ?>