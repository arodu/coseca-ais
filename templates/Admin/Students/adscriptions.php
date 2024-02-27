<?php

/**
 * @var \App\View\AppView $this
 */

use App\Enum\ActionColor;
use App\Model\Field\AdscriptionStatus;
use CakeLteTools\Utility\FaIcon;

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
        <p><?= $this->App->alertMessage() ?></p>
    <?php else : ?>
        <?php foreach ($student->student_adscriptions as $studentAdscription) : ?>
            <?php
            $institution = $studentAdscription->institution_project->institution;
            $project = $studentAdscription->institution_project;
            $tutor = $studentAdscription->tutor;
            ?>

            <div class="card">
                <div class="card-header d-flex">
                    <h3 class="card-title">
                        <?= h($studentAdscription->institution_project->label_name) ?>
                        <?= $this->App->badge($studentAdscription->enum('status')) ?>
                        <?= $this->App->badge($studentAdscription->getPrincipal()) ?>
                    </h3>
                    <div class="ml-auto">
                        <?php
                        if ($studentAdscription->enum('status')?->is(AdscriptionStatus::PENDING)) {
                            echo $this->ModalForm->link(
                                __('Activar Proyecto'),
                                ['controller' => 'Adscriptions', 'action' => 'changeStatus', AdscriptionStatus::OPEN->value, $studentAdscription->id, 'prefix' => 'Admin/Stage'],
                                [
                                    'confirm' => __('Esta seguro que desea activar este proyecto?'),
                                    'class' => ActionColor::ACTIVATE->btn('btn-sm'),
                                    'target' => 'changeStatus',
                                    'title' => __('Activar Proyecto'),
                                ]
                            );
                        } elseif ($studentAdscription->enum('status')?->is(AdscriptionStatus::OPEN)) {
                            echo $this->ModalForm->link(
                                __('Cerrar Proyecto'),
                                ['controller' => 'Adscriptions', 'action' => 'changeStatus', AdscriptionStatus::CLOSED->value, $studentAdscription->id, 'prefix' => 'Admin/Stage'],
                                [
                                    'confirm' => __('Esta seguro que desea cerrar este proyecto?'),
                                    'class' => ActionColor::DEACTIVATE->btn('btn-sm'),
                                    'target' => 'changeStatus',
                                    'title' => __('Cerrar Proyecto'),
                                ]
                            );
                        }
                        ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <dl class="row">
                                <dt class="col-sm-4"><?= __('Institución') ?></dt>
                                <dd class="col-sm-8"><?= $institution->name ?></dd>
                                <dt class="col-sm-4"><?= __('Tutor Institucional') ?></dt>
                                <dd class="col-sm-8"><?= $institution->contact_person ?></dd>
                                <dt class="col-sm-4"><?= __('Teléfono') ?></dt>
                                <dd class="col-sm-8"><?= $institution->contact_phone ?></dd>
                                <dt class="col-sm-4"><?= __('Email') ?></dt>
                                <dd class="col-sm-8"><?= $institution->contact_email ?></dd>
                            </dl>
                        </div>
                        <div class="col">
                            <dl class="row">
                                <dt class="col-sm-4"><?= __('Proyecto') ?></dt>
                                <dd class="col-sm-8"><?= $project->name ?></dd>
                                <dt class="col-sm-4"><?= __('Tutor Académico') ?></dt>
                                <dd class="col-sm-8"><?= $tutor->name ?></dd>
                                <dt class="col-sm-4"><?= __('Teléfono') ?></dt>
                                <dd class="col-sm-8"><?= $tutor->phone ?></dd>
                                <dt class="col-sm-4"><?= __('Email') ?></dt>
                                <dd class="col-sm-8"><?= $tutor->email ?></dd>
                            </dl>
                        </div>

                    </div>
                </div>
                <div class="card-footer d-flex">
                    <div>
                        <?= $this->Button->edit([
                            'label' => __('Editar'),
                            'url' => ['controller' => 'Adscriptions', 'action' => 'edit', $studentAdscription->id, 'prefix' => 'Admin/Stage'],
                        ]) ?>
                        <?= $this->Button->confirm([
                            'displayCondition' => !$studentAdscription->principal,
                            'label' => __('Establecer como principal'),
                            'url' => ['controller' => 'Adscriptions', 'action' => 'setPrincipal', $studentAdscription->id, 'prefix' => 'Admin/Stage'],
                            'actionColor' => ActionColor::ACTIVATE,
                            'icon' => FaIcon::get('success'),
                        ]) ?>
                    </div>
                    <div class="ml-auto">
                        <?php /* $this->Html->link(
                            __('Planilla de adscripción'),
                            ['controller' => 'StudentDocuments', 'action' => 'download', $studentAdscription->student_document->token],
                            ['class' => ActionColor::REPORT->btn(), 'target' => '_blank']
                        ) */ ?>
                    </div>
                </div>
            </div>
<?php endforeach; ?>
    <?php endif; ?>
</div>
<div class="card-footer d-flex">
    <div>
        <?= $this->Html->link(
            __('Agregar Proyecto'),
            ['controller' => 'Adscriptions', 'action' => 'add', $student->id, 'prefix' => 'Admin/Stage', '?' => ['redirect' => $this->Url->build()]],
            ['class' => ActionColor::ADD->btn()]
        ); ?>
    </div>
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