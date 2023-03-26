<?php

/**
 * @var \App\View\AppView $this
 */

use App\Model\Field\AdscriptionStatus;
use App\Model\Field\StageStatus;

$this->student_id = $student->id;
$this->active = 'adscriptions';
$this->extend('/Admin/Common/view_student');

$this->assign('title', __('Estudiante'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Estudiantes'), 'url' => ['controller' => 'Students', 'action' => 'index']],
    ['title' => __('Ver'), 'url' => ['controller' => 'Students', 'action' => 'view', $student->id]],
    ['title' => __('Proyectos')],
]);
?>

<div class="card-body">

    <?php if (empty($student->student_adscriptions)) : ?>
        <p><?= __('El estudiante no tiene proyectos adscritos.') ?></p>
        <p><?= __('Comuniquese con la coordinación de servicio comunitario para mas información.') ?></p>
    <?php else : ?>
        <?php foreach ($student->student_adscriptions as $studentAdscription) : ?>
            <?php
            $institution = $studentAdscription->institution_project->institution;
            $project = $studentAdscription->institution_project;
            ?>
            <div class="col-12">
                <div class="card d-flex flex-fill">
                    <div class="card-header text-muted border-bottom-0">
                        <?= $institution->name ?>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-7">
                                <h2 class="lead"><b><?= $institution->contact_person ?></b></h2>
                                <dl>
                                    <dt><?= __('Telefóno') ?></dt>
                                    <dd><?= $institution->contact_phone ?></dd>
                                    <dt><?= __('Email') ?></dt>
                                    <dd><?= $institution->contact_email ?></dd>
                                </dl>
                            </div>
                            <div class="col-5">
                                <dl>
                                    <dt><?= __('Proyecto') ?></dt>
                                    <dd><?= $project->name ?></dd>
                                </dl>
                                <dl>
                                    <dt><?= __('Estado') ?></dt>
                                    <dd><?= $this->App->badge($studentAdscription->status_obj) ?></dd>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex">
                        <div>
                            <?= $this->Html->link(
                                __('Editar'),
                                ['controller' => 'Adscriptions', 'action' => 'edit', $studentAdscription->id, 'prefix' => 'Admin/Stage'],
                                ['class' => 'btn btn-sm btn-primary']
                            ) ?>
                            <?php
                                if ($studentAdscription->status_obj->is(AdscriptionStatus::PENDING)) {
                                    echo $this->ModalForm->link(
                                        __('Activar Proyecto'),
                                        ['controller' => 'Adscriptions', 'action' => 'changeStatus', $studentAdscription->id, AdscriptionStatus::OPEN->value, 'prefix' => 'Admin/Stage'],
                                        [
                                            'confirm' => __('Esta seguro que desea activar este proyecto?'),
                                            'class' => 'btn btn-warning btn-sm',
                                            'target' => 'changeStatus',
                                            'title' => __('Activar Proyecto'),
                                        ]
                                    );
                                } elseif ($studentAdscription->status_obj->is(AdscriptionStatus::OPEN)) {
                                    echo $this->ModalForm->link(
                                        __('Cerrar Proyecto'),
                                        ['controller' => 'Adscriptions', 'action' => 'changeStatus', $studentAdscription->id, AdscriptionStatus::CLOSED->value, 'prefix' => 'Admin/Stage'],
                                        [
                                            'confirm' => __('Esta seguro que desea cerrar este proyecto?'),
                                            'class' => 'btn btn-danger btn-sm',
                                            'target' => 'changeStatus',
                                            'title' => __('Cerrar Proyecto'),
                                        ]
                                    );
                                }
                            ?>
                        </div>
                        <div class="ml-auto">
                            <?= $this->Html->link(
                                __('Planilla'),
                                ['controller' => 'StudentDocuments', 'action' => 'download', $studentAdscription->student_document->token],
                                ['class' => 'btn btn-sm btn-primary', 'target' => '_blank']
                            ) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>

<?php
echo  $this->ModalForm->modal('changeStatus', [
    'element' => \ModalForm\ModalFormPlugin::FORM_CHECKBOX,
    'content' => [
        'title' => __('Cambiar estado del Proyecto'),
        'buttonOk'  => __('Si'),
        'buttonCancel'  => __('No'),
    ]
]);
?>