<?php

/**
 * @var \App\View\AppView $this
 */

use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use CakeLteTools\Utility\FaIcon;

?>

<div class="row">

    <!-- Collapses -->
    <div class="col-lg-3">
        <div class="row">
            <!-- Collapse Filters -->
            <div class="card text-black w-100" style="max-width: 18rem;">
                <div class="card-header card-primary card-outline">
                    <h4>
                        <span class="d-flex w-100" data-toggle="collapse" href="#collapse-filters">
                            <?= __('Filtros') ?>
                            <i class="icon-caret fas fa-caret-up ml-auto fa-fw"></i>
                        </span>
                    </h4>
                </div>
                <div class="card-body collapse show" id="collapse-filters">
                    <?= $this->Form->create(null, ['type' => 'GET', 'valueSources' => ['query', 'context']]) ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <?= $this->Form->control('area_id', ['label' => __('Area'), 'empty' => __('--Todos--')]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <?= $this->Form->control('program_id', ['label' => __('Programas'), 'empty' => __('--Todos--')]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <?= $this->Form->control('tenant_id', ['label' => __('Sede'), 'empty' => __('--Todos--')]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <?= $this->Form->control('status', ['label' => __('Estado'), 'empty' => __('--Todos--'), 'options' => StageStatus::toListLabel()]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <?= $this->Form->control('stage', ['label' => __('Etapa'), 'empty' => __('--Todos--'), 'options' => StageField::toListLabel()]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <?= $this->Form->control('lapse_id', ['label' => __('Lapso'), 'empty' => __('--Todos--')]) ?>
                            </div>
                        </div>

                        <?= $this->Form->control('dni_order', ['label' => __('Ordenar por DNI'), 'options' => ['asc' => 'ASC', 'desc' => 'DESC'], 'empty' => true]) ?>

                        <?= $this->Button->search() ?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
            <!-- End Collapse Filters -->
        </div>

        <div class="row">
            <!-- Collapse Show Fields -->
            <div class="card text-black w-100" style="max-width: 18rem;">
                <div class="card-header card-warning card-outline ">
                    <h4>
                        <span class="d-flex w-100" data-toggle="collapse" href="#collapse-fields">
                            <?= __('Campos') ?>
                            <i class="icon-caret fas fa-caret-up ml-auto fa-fw"></i>
                        </span>
                    </h4>
                </div>
                <div class="card-body collapse hidden" id="collapse-fields">
                    <h4><?= _("TEST 1") ?></h4>
                </div>
            </div>
            <!-- End Collapse Show Fields -->
        </div>
        <div class="row">
            <!-- Collapse Wrap -->
            <div class="card text-black w-100" style="max-width: 18rem;">
                <div class="card-header card-success card-outline ">
                    <h4>
                        <span class="d-flex w-100" data-toggle="collapse" href="#collapse-wrap">
                            <?= __('Agrupar') ?>
                            <i class="icon-caret fas fa-caret-up ml-auto fa-fw"></i>
                        </span>
                    </h4>
                </div>
                <div class="card-body collapse hidden" id="collapse-wrap">
                    <h4><?= _("TEST 2") ?></h4>
                </div>
            </div>
            <!-- End Collapse Wrap -->
        </div>
    </div>

    <!-- Table of Reports -->
    <div class="col-lg-9">
        <div class="card card-primary card-outline table-responsive p-0 overflow-scroll" style="max-height: 1110px;">
            <div class="card-header d-flex flex-column flex-md-row align-items-center">
                <h4>Reporte</h4>
                <!-- Create Button Export To .CSV -->
                <div class="d-flex ml-auto">
                    <?= $this->Html->link(__('Exportar'), ['action' => '#export_csv'], ['class' => 'btn btn-success btn-sm ml-2']) ?>
                </div>
            </div>
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th><?= _('Área') ?></th>
                        <th><?= _('Programa') ?></th>
                        <th><?= _('Cédula') ?></th>
                        <th><?= _('Nombre') ?></th>
                        <th><?= _('Apellido') ?></th>
                        <th><?= _('Lapso') ?></th>
                        <th><?= _('Estatus') ?></th>
                        <th><?= _('Etapa') ?></th>
                        <th><?= _('Institución') ?></th>
                        <th><?= _('Proyecto') ?></th>
                        <th><?= _('Tutor') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $result) : ?>
                        <tr>
                            <td><?= h($result->student->tenant->program->area_label) ?? $this->App->nan() ?></td>
                            <td><?= h($result->student->tenant->program->name) ?></td>
                            <td><?= h($result->student->dni) ?></td>
                            <td><?= h($result->student->first_name) ?></td>
                            <td><?= h($result->student->last_name) ?></td>
                            <td><?= h($result->student->lapse->label) ?? $this->App->nan()  ?></td>
                            <td><?= $this->App->badge($result->student->last_stage->enum('status')) ?></td>
                            <td><?= h($result->stage_label) ?></td>
                            <td><?= h($result->student->tenant->label) ?></td>

                            <!-- The adscriptions is an Array Object -->
                            <?php if (!empty($result->student->student_adscriptions)) {
                                foreach ($result->student->student_adscriptions as $adscription) { ?>
                                    <!-- Only Main Project -->
                                    <?php if ($adscription->principal) { ?>
                                        <td><?= h($adscription->institution_project->name) ?></td>
                                        <td><?= h($adscription->tutor->name) ?></td>
                                <?php       }
                                }
                            } else { ?>
                                <!-- No Project -->
                                <td><?= $this->App->nan(); ?></td>
                                <td><?= $this->App->nan(); ?></td>
                            <?php } ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- End Table of Reports -->
</div>