<?php

/**
 * @var \App\View\AppView $this
 */

use App\Model\Field\AdscriptionStatus;
use App\Model\Field\StageStatus;

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
?>

<div class="card-body">
    <!--
    <?= $this->Form->create($tracking) ?>
    <div class="row">
        <div class="col">
            <?= $this->Form->control('student_adscription_id', ['options' => $adscriptionsList, 'required' => true, 'empty' => true]) ?>
        </div>
        <div class="col">
            <?= $this->Form->control('date', ['type' => 'date', 'required' => true]) ?>
        </div>
        <div class="col">
            <?= $this->Form->control('hours', ['type' => 'number', 'step' => '0.25', 'min' => '0.25', 'max' => '12', 'required' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?= $this->Form->control('description', ['required' => true]) ?>
        </div>
    </div>
    <?= $this->Form->submit(__('Guardar')) ?>

    <?= $this->Form->end() ?>
    <hr>
    -->

    <?php foreach ($student->student_adscriptions as $adscription) : ?>
        <?php
        $canAdd = in_array($adscription->status_obj, [AdscriptionStatus::OPEN]);
        $count = 0;
        $adsHours = 0;
        ?>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <?= h($adscription->institution_project->label_name) ?>

                </h3>
                <div class="card-tools">
                    <?= $adscription->label_status ?>

                    <?php if ($canAdd) : ?>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="<?= '#addTracking' . $adscription->id ?>">
                            <?= __('Agregar Actividad') ?>
                        </button>
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
                            <th></th>
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
                                $adsHours += $tracking->hours;
                                ?>
                                <tr>
                                    <td><?= $count ?></td>
                                    <td><?= h($tracking->date) ?></td>
                                    <td><?= h($tracking->description) ?></td>
                                    <td><?= h($tracking->hours) ?></td>
                                    <td class="actions">
                                        <?= $this->Form->postLink(
                                            __('Eliminar'),
                                            ['controller' => 'StudentTracking', 'action' => 'delete', $tracking->id],
                                            ['confirm' => __('¿Está seguro de eliminar este seguimiento?')]
                                        ) ?>
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
                                <strong><?= $adsHours ?></strong>
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <?php if ($canAdd) : ?>
            <!-- Modal -->
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
                        <?= $this->Form->create(null) ?>
                        <?= $this->Form->hidden('student_adscription_id', ['value' => $adscription->id]) ?>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-8">
                                    <?= $this->Form->control('date', ['type' => 'date', 'required' => true]) ?>
                                </div>
                                <div class="col-sm-4">
                                    <?= $this->Form->control('hours', ['type' => 'number', 'step' => '0.25', 'min' => '0.25', 'max' => '12', 'required' => true]) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <?= $this->Form->control('description', ['required' => true]) ?>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        <?php endif ?>
    <?php endforeach ?>

    <?php //debug($student) 
    ?>
</div>