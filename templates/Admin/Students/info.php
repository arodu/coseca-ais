<?php

/**
 * @var \App\View\AppView $this
 */

use App\Model\Field\StageStatus;

$this->student_id = $student->id;
$this->active = 'info';
$this->extend('/Admin/Common/view_student');

$this->assign('title', __('Estudiante'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Estudiantes'), 'url' => ['controller' => 'Students', 'action' => 'index']],
    ['title' => __('Ver'), 'url' => ['controller' => 'Students', 'action' => 'view', $student->id]],
    ['title' => __('Info')],
]);
?>

<div class="card-header">
    <div class="card-title"><?= __('Registro') ?></div>
</div>
<div class="card-body">
    <dl class="row">
        <dt class="col-sm-4"><?= __('Nombres') ?></dt>
        <dd class="col-sm-8 text-right mb-4"><?= h($student->first_name) ?? '<code>N/A</code>' ?></dd>

        <dt class="col-sm-4"><?= __('Apellidos') ?></dt>
        <dd class="col-sm-8 text-right mb-4"><?= h($student->last_name) ?? '<code>N/A</code>' ?></dd>

        <dt class="col-sm-4"><?= __('Cedula') ?></dt>
        <dd class="col-sm-8 text-right mb-4"><?= h($student->dni) ?? '<code>N/A</code>' ?></dd>

        <dt class="col-sm-4"><?= __('email') ?></dt>
        <dd class="col-sm-8 text-right mb-4"><?= h($student->email) ?? '<code>N/A</code>' ?></dd>

        <dt class="col-sm-4"><?= __('Genero') ?></dt>
        <dd class="col-sm-8 text-right mb-4"><?= h($student->student_data?->gender) ?? '<code>N/A</code>' ?></dd>

        <dt class="col-sm-4"><?= __('Telefono') ?></dt>
        <dd class="col-sm-8 text-right mb-4"><?= h($student->student_data?->phone) ?? '<code>N/A</code>' ?></dd>

        <dt class="col-sm-4"><?= __('Dirección') ?></dt>
        <dd class="col-sm-8 text-right mb-4"><?= h($student->student_data?->address) ?? '<code>N/A</code>' ?></dd>

        <dt class="col-sm-4"><?= __('Semestre Actual') ?></dt>
        <dd class="col-sm-8 text-right mb-4"><?= h($student->student_data?->current_semester) ?? '<code>N/A</code>' ?></dd>

        <dt class="col-sm-4"><?= __('Número de unidades de crédito aprobadas') ?></dt>
        <dd class="col-sm-8 text-right mb-4"><?= h($student->student_data?->uc) ?? '<code>N/A</code>' ?></dd>

        <dt class="col-sm-4"><?= __('Área de interés') ?></dt>
        <dd class="col-sm-8 text-right mb-4"><?= h($student->student_data?->areas) ?? '<code>N/A</code>' ?></dd>

        <dt class="col-sm-4"><?= __('Observaciones') ?></dt>
        <dd class="col-sm-8 text-right"><?= h($student->student_data?->observations) ?? '<code>N/A</code>' ?></dd>
    </dl>
</div>

<div class="card-header">
    <div class="card-title"><?= __('Adscripción') ?></div>
</div>
<div class="card-body">
    <dl class="row">
        <dt class="col-sm-4"><?= __('Institución') ?></dt>
        <dd class="col-sm-8 text-right"><?= '<code>N/A</code>' ?></dd>
    </dl>
</div>

<?php // debug($student) 
?>