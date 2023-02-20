<?php

/**
 * @var \App\View\AppView $this
 */

use App\Model\Field\StageField;

$this->student_id = $student_id;
$this->active = null;
$this->extend('/Admin/Common/view_student');
$stageField = StageField::COURSE;

$this->assign('title', __('Estudiante'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Estudiantes'), 'url' => ['controller' => 'Students', 'action' => 'index', 'prefix' => 'Admin']],
    ['title' => __('Ver'), 'url' => ['_name' => 'admin:student_view', $student_id]],
    ['title' => $stageField->label()],
    ['title' => __('Agregar')],
]);
?>

<?= $this->Form->create($studentCourse) ?>
<div class="card-header">
    <div class="card-title"><?= $stageField->label() ?></div>
</div>
<div class="card-body">
    <?php
    echo $this->Form->hidden('student_id', ['value' => $student_id]);
    echo $this->Form->control('date', ['value' => $selectedDate]);
    echo $this->Form->control('comment');
    ?>
</div>

<div class="card-footer d-flex">
    <div></div>
    <div class="ml-auto">
        <?= $this->Form->button(__('Guardar')) ?>
        <?= $this->Html->link(__('Cancelar'), ['_name' => 'admin:student_view', $student_id], ['class' => 'btn btn-default']) ?>
    </div>
</div>
<?= $this->Form->end() ?>