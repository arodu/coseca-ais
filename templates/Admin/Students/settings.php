<?php

/**
 * @var \App\View\AppView $this
 */

use App\Enum\ActionColor;
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

<div class="card mx-3 mt-3 collapsed-card">
    <div class="card-header">
        <h3 class="card-title"><?= __('Cambiar Programa/Sede') ?></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <?= $this->Form->create($student, ['url' => ['controller' => 'Students', 'action' => 'changeProgram', $student->id]]) ?>

        <div class="d-flex m-0">
            <div class="ml-auto">
                <?= $this->Form->submit('Guardar cambios', ['class' => ActionColor::SUBMIT->btn()]) ?>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>

<div class="card mx-3 collapsed-card">
    <div class="card-header">
        <h3 class="card-title"><?= __('Cambiar email') ?></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <?= $this->Form->create($student, ['url' => ['controller' => 'Students', 'action' => 'changeEmail', $student->id]]) ?>

        <?= $this->Form->control('app_user.email', ['class' => 'form-control']) ?>

        <div class="d-flex m-0">
            <div class="ml-auto">
                <?= $this->Form->submit('Guardar cambios', ['class' => ActionColor::SUBMIT->btn()]) ?>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>

<div class="card mx-3 collapsed-card">
    <div class="card-header">
        <h3 class="card-title"><?= __('Convalidar servicio comunitario') ?></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <?= $this->Form->create($student, ['url' => ['controller' => 'Students', 'action' => 'convalidation', $student->id]]) ?>

        <div class="d-flex m-0">
            <div class="ml-auto">
                <?= $this->Form->submit('Guardar cambios', ['class' => ActionColor::SUBMIT->btn()]) ?>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>

<div class="card mx-3 collapsed-card">
    <div class="card-header">
        <h3 class="card-title"><?= __('Cambiar contraseña') ?></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <?= $this->Form->create($student, ['url' => ['controller' => 'Students', 'action' => 'changePassword', $student->id]]) ?>

        <?= $this->Form->control('app_user.password', ['class' => 'form-control', 'value' => '']) ?>
        <?= $this->Form->control('app_user.confirm_password', ['class' => 'form-control', 'type' => 'password']) ?>

        <div class="d-flex m-0">
            <div class="ml-auto">
                <?= $this->Form->submit('Guardar cambios', ['class' => ActionColor::SUBMIT->btn()]) ?>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>

<div class="card mx-3 collapsed-card">
    <div class="card-header">
        <h3 class="card-title"><?= __('Eliminar Estudiante') ?></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <?= $this->Form->create($student, ['url' => ['controller' => 'Students', 'action' => 'changePassword', $student->id]]) ?>

        <div class="d-flex m-0">
            <div class="ml-auto">
                <?= $this->Form->submit('Guardar cambios', [
                    'class' => ActionColor::DELETE->btn(),
                    'confirm' => __('Esta seguro que desea eliminar al estudiantes {0}?', $student->full_name),
                ]) ?>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>