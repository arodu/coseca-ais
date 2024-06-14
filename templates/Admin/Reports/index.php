<?php

/**
 * @var \App\View\AppView $this
 */

use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use CakeLteTools\Utility\FaIcon;

?>

<div class="row justify-content-between align-items-start">

    <!-- Collapses -->
    <div class="col-lg-3" style="max-width: 370px; ">
        <div class="row">
            <!-- Collapse Filters -->
            <div class="card text-black w-100">
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
                        <div class="row">
                            <div class="col">
                                <?= $this->Button->search() ?>
                            </div>
                        </div>

                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
            <!-- End Collapse Filters -->
        </div>

        <div class="row">
            <!-- Collapse Order -->
            <div class="card text-black w-100">
                <?= $this->Form->create(null, ['type' => 'GET', 'valueSources' => ['query', 'context']]) ?>
                <div class="card-header card-warning card-outline ">
                    <h4>
                        <span class="d-flex w-100" data-toggle="collapse" href="#collapse-order">
                            <?= __('Ordenar') ?>
                            <i class="icon-caret fas fa-caret-up ml-auto fa-fw"></i>
                        </span>
                    </h4>
                </div>
                <div class="card-body collapse hidden" id="collapse-order">
                    <?= $this->Form->control('dni_order', ['label' => __('Cedula'), 'options' => ['asc' => 'ASC', 'desc' => 'DESC'], 'empty' => _('--Seleccionar--')]) ?>
                    <?= $this->Form->control('area_order', ['label' => __('Area'), 'options' => ['asc' => 'ASC', 'desc' => 'DESC'], 'empty' => _('--Seleccionar--')]) ?>
                    <?= $this->Form->control('program_order', ['label' => __('Programa'), 'options' => ['asc' => 'ASC', 'desc' => 'DESC'], 'empty' => _('--Seleccionar--')]) ?>
                    <?= $this->Form->control('firstname_order', ['label' => __('Nombre'), 'options' => ['asc' => 'ASC', 'desc' => 'DESC'], 'empty' => _('--Seleccionar--')]) ?>
                    <?= $this->Form->control('lastname_order', ['label' => __('Apellido'), 'options' => ['asc' => 'ASC', 'desc' => 'DESC'], 'empty' => _('--Seleccionar--')]) ?>
                    <?= $this->Button->search() ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
            <!-- End Collapse Order -->
        </div>


        <div class="row">
            <!-- Collapse Show Fields -->
            <div class="card text-black w-100">
                <div class="card-header card-warning card-outline ">
                    <h4>
                        <span class="d-flex w-100" data-toggle="collapse" href="#collapse-fields">
                            <?= __('Campos') ?>
                            <i class="icon-caret fas fa-caret-up ml-auto fa-fw"></i>
                        </span>
                    </h4>
                </div>
                <div class="card-body collapse hidden" id="collapse-fields">
                    <?= $this->Form->create(null, ['url' => ['action' => 'bulkActions']]) ?>
                    <div class="container">
                        <div class="row">
                            <div class="col form-check d-flex bd-highlight justify-content-between">
                                <div><?= $this->BulkAction->checkboxAll('all', ['checked' => true]) ?></div>
                                <h5>Mostrar todo</h5>
                            </div>
                        </div>
                        <hr>
                        <div class="row" id="check-fields">
                            <div class="col d-flex flex-column bd-highlight mb-3 mr-2">
                                <div class="d-flex bd-highlight mb-3 justify-content-between"><?= $this->BulkAction->checkbox('item', ['value' => 'Área', 'checked' => true]) ?><span><b><?= h('Área') ?></b></span></div>
                                <div class="d-flex bd-highlight mb-3 justify-content-between">
                                    <?= $this->BulkAction->checkbox('item', ['value' => 'Programa', 'checked' => true]) ?> <span><b><?= h('Programa') ?></b></span>
                                </div>
                                <div class="d-flex bd-highlight mb-3 justify-content-between">
                                    <?= $this->BulkAction->checkbox('item', ['value' => 'Cédula', 'checked' => true]) ?> <span><b><?= h('Cédula') ?></b></span>
                                </div>
                                <div class="d-flex bd-highlight mb-3 justify-content-between">
                                    <?= $this->BulkAction->checkbox('item', ['value' => 'Nombre', 'checked' => true]) ?> <span><b><?= h('Nombre') ?></b></span>
                                </div>
                                <div class="d-flex bd-highlight mb-3 justify-content-between">
                                    <?= $this->BulkAction->checkbox('item', ['value' => 'Apellido', 'checked' => true]) ?> <span><b><?= h('Apellido') ?></b></span>
                                </div>
                                <div class="d-flex bd-highlight mb-3 justify-content-between">
                                    <?= $this->BulkAction->checkbox('item', ['value' => 'Lapso', 'checked' => true]) ?> <span><b><?= h('Lapso') ?></b></span>
                                </div>
                            </div>
                            <div class="col d-flex flex-column bd-highlight mb-3">
                                <div class="d-flex bd-highlight mb-3 justify-content-between">
                                    <?= $this->BulkAction->checkbox('item', ['value' => 'Estatus', 'checked' => true]) ?> <span><b><?= h('Estatus') ?></b></span>
                                </div>
                                <div class="d-flex bd-highlight mb-3 justify-content-between">
                                    <?= $this->BulkAction->checkbox('item', ['value' => 'Etapa', 'checked' => true]) ?> <span><b><?= h('Etapa') ?></b></span>
                                </div>
                                <div class="d-flex bd-highlight mb-3 justify-content-between">
                                    <?= $this->BulkAction->checkbox('item', ['value' => 'Institución', 'checked' => true]) ?> <span><b><?= h('Institución') ?></b></span>
                                </div>
                                <div class="d-flex bd-highlight mb-3 justify-content-between">
                                    <?= $this->BulkAction->checkbox('item', ['value' => 'Proyecto', 'checked' => true]) ?> <span><b><?= h('Proyecto') ?></b></span>
                                </div>
                                <div class="d-flex bd-highlight mb-3 justify-content-between">
                                    <?= $this->BulkAction->checkbox('item', ['value' => 'Tutor', 'checked' => true]) ?> <span><b><?= h('Tutor') ?></b></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
            <!-- End Collapse Show Fields -->
        </div>
        <div class="row">
            <!-- Collapse Wrap -->
            <div class="card text-black w-100">
                <div class="card-header card-success card-outline ">
                    <h4>
                        <span class="d-flex w-100" data-toggle="collapse" href="#collapse-wrap">
                            <?= __('Agrupar') ?>
                            <i class="icon-caret fas fa-caret-up ml-auto fa-fw"></i>
                        </span>
                    </h4>
                </div>
                <div class="card-body collapse hidden" id="collapse-wrap">
                    <div class="row">
                        <?= $this->Form->create(null, ['type' => 'GET', 'valueSources' => ['query', 'context']]) ?>
                        <div class="col">
                            <?= $this->Form->control('wrap', ['label' => __('Agrupar por:'), 'empty' => __(''), 'options' => ['Area', 'Programa', 'Institucion', 'Proyecto']]) ?>
                        </div>
                        <div class="col">
                            <?= $this->Button->search() ?>
                        </div>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
            <!-- End Collapse Wrap -->
        </div>
    </div>

    <!-- Table of Reports -->
    <div class="col-lg-9">
        <div class="card card-primary card-outline  p-0" style="max-height: 1110px;">
            <div class="card-header d-flex flex-column flex-md-row align-items-center">
                <h4>Reporte</h4>
                <!-- Create Button Export To .CSV -->
                <div class="d-flex ml-auto">
                    <?= $this->Html->link(__('Exportar'), ['action' => '#export_csv'], ['class' => 'btn btn-success btn-sm ml-2']) ?>
                </div>
            </div>
            <table class="table table-hover text-nowrap table-responsive">
                <thead>
                    <tr>
                        <th class="area"><?= _('Área') ?></th>
                        <th class="program"><?= _('Programa') ?></th>
                        <th class="dni"><?= _('Cédula') ?></th>
                        <th class="first_name"><?= _('Nombre') ?></th>
                        <th class="last_name"><?= _('Apellido') ?></th>
                        <th class="lapse"><?= _('Lapso') ?></th>
                        <th class="status"><?= _('Estatus') ?></th>
                        <th class="stage"><?= _('Etapa') ?></th>
                        <th class="institution"><?= _('Institución') ?></th>
                        <th class="tenant"><?= _('Proyecto') ?></th>
                        <th class="tutor"><?= _('Tutor') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $result) : ?>
                        <tr>
                            <td class="area"><?= h($result->student->tenant->program->area_label) ?? $this->App->nan() ?></td>
                            <td class="program"><?= h($result->student->tenant->program->name) ?></td>
                            <td class="dni"><?= h($result->student->dni) ?></td>
                            <td class="first_name"><?= h($result->student->first_name) ?></td>
                            <td class="last_name"><?= h($result->student->last_name) ?></td>
                            <td class="lapse"><?= h($result->student->lapse->label) ?? $this->App->nan()  ?></td>
                            <td class="status"><?= $this->App->badge($result->student->last_stage->enum('status')) ?></td>
                            <td class="stage"><?= h($result->stage_label) ?></td>
                            <td class="institution"><?= h($result->student->tenant->label) ?></td>

                            <!-- The adscriptions is an Array Object -->
                            <?php if (!empty($result->student->student_adscriptions)) {
                                foreach ($result->student->student_adscriptions as $adscription) { ?>
                                    <!-- Only Main Project -->
                                    <?php if ($adscription->principal) { ?>
                                        <td class="tenant"><?= h($adscription->institution_project->name) ?></td>
                                        <td class="tutor"><?= h($adscription->tutor->name) ?></td>
                                <?php       }
                                }
                            } else { ?>
                                <!-- No Project -->
                                <td class="tenant"><?= $this->App->nan(); ?></td>
                                <td class="tutor"><?= $this->App->nan(); ?></td>
                            <?php } ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- End Table of Reports -->
</div>

<?= $this->BulkAction->scripts() ?>

<script>
    //Conatiner of check fiedls
    const container = document.querySelector('#check-fields');
    //Checkbox
    const checkboxAll = document.querySelector('.bulk-all');
    //Fields Table => <th> and <td>
    const fieldArea = document.querySelectorAll('.area');
    const fieldProgram = document.querySelectorAll('.program');
    const fieldDni = document.querySelectorAll('.dni');
    const fieldFirstName = document.querySelectorAll('.first_name');
    const fieldLastName = document.querySelectorAll('.last_name');
    const fieldLapse = document.querySelectorAll('.lapse');
    const fieldStatus = document.querySelectorAll('.status');
    const fieldStage = document.querySelectorAll('.stage');
    const fieldInstitution = document.querySelectorAll('.institution');
    const fieldTenant = document.querySelectorAll('.tenant');
    const fieldTutor = document.querySelectorAll('.tutor');
    //flag
    let isHidden = false;

    const fields = (visibility) => {
        fieldArea.forEach(field => isHidden ? field.style.display = 'none' : field.style.display = 'table-cell');
        fieldProgram.forEach(field => isHidden ? field.style.display = 'none' : field.style.display = 'table-cell');
        fieldDni.forEach(field => isHidden ? field.style.display = 'none' : field.style.display = 'table-cell');
        fieldFirstName.forEach(field => isHidden ? field.style.display = 'none' : field.style.display = 'table-cell');
        fieldLastName.forEach(field => isHidden ? field.style.display = 'none' : field.style.display = 'table-cell');
        fieldLapse.forEach(field => isHidden ? field.style.display = 'none' : field.style.display = 'table-cell');
        fieldStatus.forEach(field => isHidden ? field.style.display = 'none' : field.style.display = 'table-cell');
        fieldStage.forEach(field => isHidden ? field.style.display = 'none' : field.style.display = 'table-cell');
        fieldInstitution.forEach(field => isHidden ? field.style.display = 'none' : field.style.display = 'table-cell');
        fieldTenant.forEach(field => isHidden ? field.style.display = 'none' : field.style.display = 'table-cell');
        fieldTutor.forEach(field => isHidden ? field.style.display = 'none' : field.style.display = 'table-cell');
    }

    //Event Click checkboxAll
    checkboxAll.addEventListener('click', () => {
        isHidden = !isHidden;
        fields(isHidden)
    });

    container.addEventListener('click', (e) => {
        if (e.target && e.target.tagName === 'INPUT') {
            switch (e.target.value) {
                case 'Área':
                    fieldArea.forEach(field => !e.target.checked ? field.style.display = 'none' : field.style.display = 'table-cell');
                    break;
                case 'Programa':
                    fieldProgram.forEach(field => !e.target.checked ? field.style.display = 'none' : field.style.display = 'table-cell');
                    break;
                case 'Cédula':
                    fieldDni.forEach(field => !e.target.checked ? field.style.display = 'none' : field.style.display = 'table-cell');
                    break;
                case 'Nombre':
                    fieldFirstName.forEach(field => !e.target.checked ? field.style.display = 'none' : field.style.display = 'table-cell');
                    break;
                case 'Apellido':
                    fieldLastName.forEach(field => !e.target.checked ? field.style.display = 'none' : field.style.display = 'table-cell');
                    break;
                case 'Lapso':
                    fieldLapse.forEach(field => !e.target.checked ? field.style.display = 'none' : field.style.display = 'table-cell');
                    break;
                case 'Estatus':
                    fieldStatus.forEach(field => !e.target.checked ? field.style.display = 'none' : field.style.display = 'table-cell');
                    break;
                case 'Etapa':
                    fieldStage.forEach(field => !e.target.checked ? field.style.display = 'none' : field.style.display = 'table-cell');
                    break;
                case 'Institución':
                    fieldInstitution.forEach(field => !e.target.checked ? field.style.display = 'none' : field.style.display = 'table-cell');
                    break;
                case 'Proyecto':
                    fieldTenant.forEach(field => !e.target.checked ? field.style.display = 'none' : field.style.display = 'table-cell');
                    break;
                case 'Tutor':
                    fieldTutor.forEach(field => !e.target.checked ? field.style.display = 'none' : field.style.display = 'table-cell');
                    break;
            }
        }
    })
</script>