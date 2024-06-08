<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StudentAdscription $adscription
 */

use App\Enum\ActionColor;
use App\Model\Field\AdscriptionStatus;

$this->student_id = $adscription->student_id;
$this->active = null;
$this->extend('/Admin/Common/view_student');

$this->assign('title', __('Estudiante'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Estudiantes'), 'url' => ['controller' => 'Students', 'action' => 'index']],
    ['title' => __('Ver'), 'url' => ['_name' => 'admin:student:view', $adscription->student_id]],
    ['title' => __('Editar Proyecto')],
]);
?>


<?= $this->Form->create($adscription) ?>
<div class="card-header d-flex">
    <div class="card-title"><?= __('Editar Proyecto') ?></div>
    <div class="ml-auto">
        <?= $this->ModalForm->Link(
            __('Cancelar proyecto'),
            ['action' => 'cancel', $adscription->id],
            [
                'confirm' => __('Are you sure you want to cancel # {0}?', $adscription->id),
                'class' => ActionColor::DELETE->btn('btn-sm'),
                'target' => 'deleteAdscription',
            ]
        ) ?>
    </div>
</div>
<div class="card-body">

    <div class="table-responsive">
        <table class="table table-sm table-borderless table-hover m-0">
            <thead>
                <tr>
                    <th><?= __('Institución') ?></th>
                    <th><?= __('Proyecto') ?></th>
                    <th><?= __('Tutor') ?></th>
                    <th><?= __('Estado') ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $adscription->institution_project->institution->name ?></td>
                    <td><?= $adscription->institution_project->name ?></td>
                    <td><?= $adscription->tutor->name ?></td>
                    <td><?= $this->App->badge($adscription->enum('status')) ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <hr>
    <?= $this->Form->control('institution_project_id', ['options' => $institution_projects ?? [], 'empty' => true]) ?>
    <?= $this->Form->control('status', ['options' => AdscriptionStatus::getEditableListLabel(), 'empty' => true]) ?>
    <?= $this->Form->control('tutor_id', ['options' => $tutors, 'empty' => true]) ?>
</div>

<div class="card-footer d-flex">
    <div class="">
        <?= $this->Button->save() ?>
    </div>
    <div class="ml-auto">
        <?= $this->Button->cancel(['url' => ['_name' => 'admin:student:adscriptions', $adscription->student_id]]) ?>
    </div>
</div>

<?= $this->Form->end() ?>

<?php
echo  $this->ModalForm->modal('deleteAdscription', [
    'element' => \ModalForm\ModalFormPlugin::FORM_CHECKBOX,
    'content' => [
        'title' => __('Eliminar Proyecto'),
        'buttonOk'  => __('Si, eliminar'),
        'buttonCancel'  => __('Cancelar'),
    ]
]);
?>