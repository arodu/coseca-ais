<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StudentAdscription $student_adscription
 */

$this->student_id = $studentStage->student_id;
$this->active = null;
$this->extend('/Admin/Common/view_student');

$this->assign('title', __('Estudiante'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Estudiantes'), 'url' => ['controller' => 'Students', 'action' => 'index']],
    ['title' => __('Ver'), 'url' => ['controller' => 'Students', 'action' => 'view', $studentStage->student_id]],
    ['title' => __('Agregar Proyecto')],
]);
?>


<?= $this->Form->create($student_adscription) ?>
<div class="card-header">
    <div class="card-title"><?= __('Agregar Proyecto') ?></div>
</div>
<div class="card-body">
    <?php
    echo $this->Form->hidden('student_id', ['value' => $studentStage->student_id]);
    echo $this->Form->control('institution_project_id', ['options' => $institution_projects, 'empty' => true]);
    echo $this->Form->control('lapse_id', ['options' => $lapses, 'empty' => true]);
    echo $this->Form->control('tutor_id', ['options' => $tutors, 'empty' => true]);
    ?>
</div>

<div class="card-footer d-flex">
    <div class="ml-auto">
        <?= $this->Form->button(__('Guardar')) ?>
        <?= $this->Html->link(__('Cancelar'), ['controller' => 'Students', 'action' => 'view', $studentStage->student_id], ['class' => 'btn btn-default']) ?>
    </div>
</div>

<?= $this->Form->end() ?>