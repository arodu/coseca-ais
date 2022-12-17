<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StudentAdscription $adscription
 */

$this->student_id = $adscription->student_id;
$this->active = null;
$this->extend('/Admin/Common/view_student');

$this->assign('title', __('Estudiante'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Estudiantes'), 'url' => ['controller' => 'Students', 'action' => 'index']],
    ['title' => __('Ver'), 'url' => ['_name' => 'admin:student_view', $adscription->student_id]],
    ['title' => __('Editar Proyecto')],
]);
?>


<?= $this->Form->create($adscription) ?>
<div class="card-header">
    <div class="card-title"><?= __('Editar Proyecto') ?></div>
</div>
<div class="card-body">

    <div class="table-responsive">
        <table class="table table-sm table-borderless table-hover m-0">
            <tr>
                <th><?= __('Institución') ?></th>
                <th><?= __('Proyecto') ?></th>
                <th><?= __('Lapso') ?></th>
                <th><?= __('Tutor') ?></th>
                <th><?= __('Estado') ?></th>
            </tr>
            <tr>
                <td><?= $adscription->institution_project->institution->name ?></td>
                <td><?= $adscription->institution_project->name ?></td>
                <td><?= $adscription->lapse->name ?></td>
                <td><?= $adscription->tutor->name ?></td>
                <td><?= $adscription->lapse->active ? __('Activo') : __('Inactivo') ?></td>
            </tr>
        </table>
    </div>

    <hr>

    <?php
    //echo $this->Form->control('institution_project_id', ['options' => $institution_projects, 'empty' => true]);
    echo $this->Form->control('tutor_id', ['options' => $tutors, 'empty' => true]);
    ?>
</div>

<div class="card-footer d-flex">
    <div class="">
        <?= $this->ModalForm->Link(
            __('Delete'),
            ['action' => 'delete', $adscription->id],
            [
                'confirm' => __('Are you sure you want to delete # {0}?', $adscription->id),
                'class' => 'btn btn-danger',
                'target' => 'deleteAdscription',
            ]
        ) ?>
    </div>
    <div class="ml-auto">
        <?= $this->Form->button(__('Guardar')) ?>
        <?= $this->Html->link(__('Cancelar'), ['_name' => 'admin:student_view', $adscription->student_id], ['class' => 'btn btn-default']) ?>
    </div>
</div>

<?= $this->Form->end() ?>

<?php
echo  $this->ModalForm->addModal('deleteAdscription', [
    'element' => \ModalForm\ModalFormPlugin::FORM_CHECKBOX,
    'content' => [
        'title' => __('Eliminar Proyecto'),
        'buttonOk'  => __('Enviar'),
        'buttonCancel'  => __('Cancelar'),
    ]
]);
?>