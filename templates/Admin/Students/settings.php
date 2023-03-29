<?php

/**
 * @var \App\View\AppView $this
 */

use App\Model\Field\StageStatus;

$this->student_id = $student->id;
$this->active = 'settings';
$this->extend('/Admin/Common/view_student');

$this->assign('title', __('Estudiante'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Estudiantes'), 'url' => ['controller' => 'Students', 'action' => 'index']],
    ['title' => __('Ver'), 'url' => ['controller' => 'Students', 'action' => 'view', $student->id]],
    ['title' => __('Configuración')],
]);
?>

<div class="card mx-3 mt-3">
    <div class="card-header">
        <div class="card-title"><?= __('Cambiar Programa/Sede') ?></div>
    </div>
    <?= $this->Form->create($student, ['url' => ['controller' => 'Students', 'action' => 'changeProgram', $student->id]]) ?>
    <div class="card-body">


    </div>
    <div class="card-footer d-flex">
        <div class="ml-auto">
            <?= $this->Form->submit('Guardar cambios', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>

<div class="card mx-3 mt-3">
    <div class="card-header">
        <div class="card-title"><?= __('Cambiar email') ?></div>
    </div>
    <?= $this->Form->create($student, ['url' => ['controller' => 'Students', 'action' => 'changeEmail', $student->id]]) ?>
    <div class="card-body">
        <?= $this->Form->control('app_user.email', ['class' => 'form-control']) ?>
    </div>
    <div class="card-footer d-flex">
        <div class="ml-auto">
            <?= $this->ModalForm->submit('Guardar cambios', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>

<div class="card mx-3 mt-3">
    <div class="card-header">
        <div class="card-title"><?= __('Convalidar servicio comunitario') ?></div>
    </div>
    <?= $this->Form->create($student, ['url' => ['controller' => 'Students', 'action' => 'convalidation', $student->id]]) ?>
    <div class="card-body"></div>
    <div class="card-footer d-flex">
        <div class="ml-auto">
            <?= $this->Form->submit('Guardar cambios', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>

<div class="card mx-3 mt-3">
    <div class="card-header">
        <div class="card-title"><?= __('Cambiar contraseña') ?></div>
    </div>
    <?= $this->Form->create($student, ['url' => ['controller' => 'Students', 'action' => 'changePassword', $student->id]]) ?>
    <div class="card-body">
    </div>
    <div class="card-footer d-flex">
        <div class="ml-auto">
            <?= $this->ModalForm->submit(
                __('Guardar cambios'),
                [
                    'confirm' => __('Esta seguro que desea cambiar la contraseña del estudiante {0}?', $student->full_name),
                    'class' => 'btn btn-primary',
                    'target' => 'changeEmail',
                ]
            ) ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>


<div class="card mx-3 mt-3">
    <div class="card-header">
        <div class="card-title"><?= __('Eliminar Estudiante') ?></div>
    </div>
    <div class="card-footer d-flex">
        <div class="ml-auto">
            <?= $this->ModalForm->Link(
                __('Eliminar Studiante'),
                ['action' => 'delete', $student->id],
                [
                    'confirm' => __('Esta seguro que desea eliminar al estudiantes {0}?', $student->full_name),
                    'class' => 'btn btn-danger',
                    'target' => 'deleteStudent',
                ]
            ) ?>
        </div>
    </div>
</div>

<?php
echo  $this->ModalForm->modal('changeEmail', [
    'element' => \ModalForm\ModalFormPlugin::FORM_TIMER,
    'content' => [
        'title' => __('Cambiar contraseña'),
        'buttonOk'  => __('Realizar'),
        'buttonCancel'  => __('Cancelar'),
    ]
]);
?>

<?php
echo  $this->ModalForm->modal('deleteStudent', [
    'element' => \ModalForm\ModalFormPlugin::FORM_TIMER,
    'content' => [
        'title' => __('Eliminar Estudiante'),
        'buttonOk'  => __('Realizar'),
        'buttonCancel'  => __('Cancelar'),
    ]
]);
?>