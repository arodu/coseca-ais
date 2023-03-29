<?php

/**
 * @var \App\View\AppView $this
 */

use App\Enum\ActionColor;
use App\Model\Field\AdscriptionStatus;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Utility\FaIcon;

$user = $this->request->getAttribute('identity');

$this->student_id = $student->id;
$this->active = 'tracking';
$this->extend('/Admin/Common/view_student');

$this->assign('title', __('Estudiante'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Estudiantes'), 'url' => ['controller' => 'Students', 'action' => 'index']],
    ['title' => __('Ver'), 'url' => ['controller' => 'Students', 'action' => 'view', $student->id]],
    ['title' => __('Seguimiento')],
]);


$trackingDates = $student->lapse->getDates(StageField::TRACKING);
?>

<div class="card-body">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?= __('Seguimiento: {0}', $student->lapse->name) ?></h3>
        </div>
        <div class="card-body">
            <?= $this->element('content/trackingInfo', ['trackingInfo' => $trackingInfo]) ?>
        </div>
    </div>


    <?php foreach ($student->student_adscriptions as $adscription) : ?>
        <?php
        $canManageTracking = $user->can('manageTracking', $adscription);
        $count = 0;
        $sumHours = 0;
        ?>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <?= h($adscription->institution_project->label_name) ?>
                    <?= $this->App->badge($adscription->status_obj) ?>
                </h3>
                <div class="card-tools">
                    <?php if ($canManageTracking) : ?>
                        <button type="button" class="<?= ActionColor::ADD->btn('btn-sm') ?>" data-toggle="modal" data-target="<?= '#addTracking' . $adscription->id ?>">
                            <?= __('Agregar Actividad') ?>
                        </button>
                    <?php endif ?>
                    <?php if ($adscription->statusObj->is(AdscriptionStatus::CLOSED)) : ?>
                        <?= $this->ModalForm->link(
                            __('Validar horas del proyecto'),
                            ['controller' => 'Adscriptions', 'action' => 'validate', $adscription->id, 'prefix' => 'Admin/Stage'],
                            [
                                'class' => ActionColor::VALIDATE->btn('btn-sm'),
                                'confirm' => __('¿Está seguro de validar este proyecto?'),
                                'target' => 'validateTracking' . $adscription->id,
                            ]
                        );
                        ?>
                    <?php endif ?>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?= __('Fecha') ?></th>
                            <th><?= __('Actividad') ?></th>
                            <th><?= __('Horas') ?></th>
                            <th class="actions"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($adscription->student_tracking)) : ?>
                            <tr>
                                <td colspan="5">
                                    <?= __('No hay seguimiento para esta adscripción') ?>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($adscription->student_tracking as $tracking) : ?>
                                <?php
                                $count++;
                                $sumHours += $tracking->hours;
                                ?>
                                <tr>
                                    <td><?= $count ?></td>
                                    <td><?= h($tracking->date) ?></td>
                                    <td><?= h($tracking->description) ?></td>
                                    <td><?= h($tracking->hours) ?></td>
                                    <td class="actions">
                                        <?php
                                        if ($canManageTracking) :
                                            echo $this->ModalForm->link(
                                                __('Eliminar'),
                                                ['controller' => 'Tracking', 'action' => 'delete', $tracking->id, 'prefix' => 'Admin/Stage'],
                                                [
                                                    'confirm' => __('¿Está seguro de eliminar este seguimiento?'),
                                                    'target' => 'deleteTracking' . $adscription->id,
                                                    'class' => ActionColor::DELETE->btn('btn-xs'),
                                                    'escape' => false,
                                                ]
                                            );
                                        endif;
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-right">
                                <strong><?= __('Total') ?></strong>
                            </td>
                            <td>
                                <strong><?= $sumHours ?></strong>
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <?php if ($canManageTracking) : ?>
            <div class="modal fade" id="<?= 'addTracking' . $adscription->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                <?= h($adscription->institution_project->label_name) ?>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?= $this->Form->create(null, ['url' => ['controller' => 'Tracking', 'action' => 'add', 'prefix' => 'Admin/Stage']]) ?>
                        <?= $this->Form->hidden('student_adscription_id', ['value' => $adscription->id]) ?>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-8">
                                    <?= $this->Form->control('date', [
                                        'label' => __('Fecha'),
                                        'type' => 'date',
                                        'required' => true,
                                        'min' => $trackingDates['start_date']?->format('Y-m-d') ?? '',
                                        'max' => $trackingDates['end_date']?->format('Y-m-d') ?? '',
                                    ]) ?>
                                </div>
                                <div class="col-sm-4">
                                    <?= $this->Form->control('hours', [
                                        'label' => __('Horas'),
                                        'type' => 'number',
                                        'required' => true,
                                        'step' => '0.25',
                                        'min' => '0.25',
                                        'max' => '12',
                                    ]) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <?= $this->Form->control('description', [
                                        'label' => __('Actividad'),
                                        'required' => true,
                                    ]) ?>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="<?= ActionColor::SUBMIT->btn() ?>"><?= __('Guardar') ?></button>
                            <button type="button" class="<?= ActionColor::CANCEL->btn() ?>" data-dismiss="modal"><?= __('Cancelar') ?></button>
                        </div>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        <?php endif ?>

        <?php
        echo $this->ModalForm->modal('deleteTracking' . $adscription->id, [
            'element' => \ModalForm\ModalFormPlugin::FORM_CHECKBOX,
            'content' => [
                'title' => __('Eliminar Seguimiento'),
                'buttonOk'  => __('Si, eliminar'),
                'buttonCancel'  => __('Cancelar'),
            ]
        ]);

        echo $this->ModalForm->modal('validateTracking' . $adscription->id, [
            'element' => \ModalForm\ModalFormPlugin::FORM_TEXT_INPUT,
            'content' => [
                'title' => __('Validar proyecto'),
                'buttonOk'  => __('Si, validar'),
                'buttonCancel'  => __('Cancelar'),
                'textConfirm' => $adscription->institution_project->label_name,
                'label' => function ($content) {
                    return __('Escribe:<br><code>{0}</code><br>para confirmar', $content['textConfirm']);
                }
            ]
        ]);
        ?>
    <?php endforeach ?>
</div>