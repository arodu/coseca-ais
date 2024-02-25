<?php

/**
 * @var \App\View\AppView $this
 */

use App\Enum\ActionColor;
use App\Model\Field\StageStatus;
use App\Utility\Tenants;
use CakeLteTools\Utility\FaIcon;

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
<div class="mt-3"></div>

<div class="card mx-3 collapsed-card">
    <div class="card-header">
        <h3 class="card-title"><?= __('Cambiar Programa/Sede') ?></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <?= $this->Form->create($student, ['url' => ['controller' => 'Students', 'action' => 'newProgram', $student->id]]) ?>

        <?= $this->Form->control('tenant_id', [
            'options' => Tenants::getTenantList(),
            'empty' => __('Seleccione un programa/sede'),
            'label' => __('Programa/Sede'),
            'required' => true,
        ]) ?>

        <p>Esta accion hara que se desactive el registro del estudiante actual, y se cree uno nuevo en el programa/sede seleccionado.</p>

        <?= $this->Form->control('verification', [
            'type' => 'checkbox',
            'label' => __('¿Esta seguro que quiere cambiar el programa/sede de {0}?', $student->full_name),
            'required' => true,
        ]) ?>

        <div class="d-flex m-0">
            <div class="ml-auto">
                <?= $this->Button->save([
                    'label' => __('Guardar'),
                    'icon' => null,
                ])  ?>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>

<?php if ($student->active) : ?>
    <div class="card mx-3 collapsed-card">
        <div class="card-header">
            <h3 class="card-title"><?= __('Desactivar Estudiante') ?></h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <?= $this->Form->create($student, ['url' => ['controller' => 'Students', 'action' => 'deactivate', $student->id]]) ?>
            <?= $this->Form->control('verification', [
                'type' => 'checkbox',
                'label' => __('¿Esta seguro que quiere desactivar a {0}?', $student->full_name),
                'required' => true,
            ]) ?>
            <div class="d-flex m-0">
                <div class="ml-auto">
                    <?= $this->Button->save([
                        'label' => __('Desactivar'),
                        'icon' => null,
                        'actionColor' => ActionColor::ACTIVATE,
                    ])  ?>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
<?php else : ?>
    <div class="card mx-3 collapsed-card">
        <div class="card-header">
            <h3 class="card-title"><?= __('Reactivar Estudiante') ?></h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <?= $this->Form->create($student, ['url' => ['controller' => 'Students', 'action' => 'reactivate', $student->id]]) ?>
            <?= $this->Form->control('verification', [
                'type' => 'checkbox',
                'label' => __('¿Esta seguro que quiere reactivar a {0}?', $student->full_name),
                'required' => true,
            ]) ?>
            <div class="d-flex m-0">
                <div class="ml-auto">
                    <?= $this->Button->save([
                        'label' => __('Reactivar'),
                        'icon' => null,
                        'actionColor' => ActionColor::ACTIVATE,
                    ])  ?>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
<?php endif; ?>

<div class="card mx-3 collapsed-card">
    <div class="card-header">
        <h3 class="card-title"><?= __('Eliminar Estudiante') ?></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <?= $this->Form->create($student, ['type' => 'DELETE', 'url' => ['controller' => 'Students', 'action' => 'delete', $student->id]]) ?>

        <p>Esta accion eliminara el registro del estudiante actual y todas las acciones relacionadas con el.</p>

        <?= $this->Form->control('verification', [
            'type' => 'checkbox',
            'label' => __('¿Esta seguro que quiere eliminar al estudiante {0}?', $student->full_name),
            'required' => true,
        ]) ?>

        <div class="d-flex m-0">
            <div class="ml-auto">
                <?= $this->Button->save([
                    'label' => __('Eliminar'),
                    'icon' => null,
                    'actionColor' => ActionColor::DELETE,
                ])  ?>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>



<?php /*
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



*/ ?>
