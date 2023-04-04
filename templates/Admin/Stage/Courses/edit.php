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
    ['title' => __('Ver'), 'url' => ['_name' => 'admin:student:view', $student_id]],
    ['title' => $stageField->label()],
    ['title' => __('Agregar')],
]);
?>

<?= $this->Form->create($studentCourse) ?>
<div class="card-header d-flex">
    <div class="card-title"><?= $stageField->label() ?></div>
    <div class="ml-auto">
        <?php
        if (!empty($studentCourse->id)) :
            echo $this->ModalForm->link(
                __('Eliminar'),
                ['action' => 'delete', $studentCourse->id],
                [
                    'confirm' => __('Are you sure you want to delete # {0}?', $studentCourse->id),
                    'class' => 'btn btn-danger btn-sm',
                    'target' => 'deleteCourse',
                ]
            );
        endif;
        ?>
    </div>
</div>
<div class="card-body">
    <?php
    echo $this->Form->hidden('student_id', ['value' => $student_id]);
    echo $this->Form->control('date', ['value' => $studentCourse->date ?? $selectedDate]);
    echo $this->Form->control('comment');
    ?>
</div>

<div class="card-footer d-flex">
    <div class="ml-auto">
        <?= $this->Button->save() ?>
        <?= $this->Button->validate() ?>
        <?= $this->Button->cancel(['url' => ['_name' => 'admin:student:view', $student_id]]) ?>
    </div>
</div>
<?= $this->Form->end() ?>

<?php
echo  $this->ModalForm->modal('deleteCourse', [
    'element' => \ModalForm\ModalFormPlugin::FORM_CHECKBOX,
    'content' => [
        'title' => __('Eliminar Curso'),
        'buttonOk'  => __('Si, eliminar'),
        'buttonCancel'  => __('Cancelar'),
    ]
]);
?>