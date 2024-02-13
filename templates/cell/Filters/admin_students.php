<?php
/**
 * @var \App\View\AppView $this
 */

use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use CakeLteTools\Utility\FaIcon;

?>
<div class="card card-success card-outline">
    <div class="card-header d-flex flex-column flex-md-row">
        <h2 class="card-title w-100">
            <span class="d-flex w-100" data-toggle="collapse" href="#collapse-filters">
                <?= FaIcon::get('filter', 'fa-fw mr-2') ?>
                <?= __('Filtros') ?>
                <i class="icon-caret fas fa-caret-up ml-auto fa-fw"></i>
            </span>
        </h2>
    </div>
    <?= $this->Form->create(null, ['type' => 'GET', 'valueSources' => ['query', 'context']]) ?>
    <?= $this->Form->hidden('limit', ['value' => $limit ?? 20]) ?>
    <div class="collapse <?= (($isFiltered ?? false) ? 'show' : null) ?>" id="collapse-filters">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <?= $this->Form->control($filterKey . '.names', ['label' => __('Nombres/Apellidos')]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $this->Form->control($filterKey . '.dni', ['label' => __('Cedula')]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $this->Form->control($filterKey . '.lapse', ['label' => __('Lapso Académico'), 'empty' => __('--Todos--'), 'options' => $lapses]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= $this->Form->control($filterKey . '.tenant_id', ['label' => __('Programa'), 'empty' => __('--Todos--')]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $this->Form->control($filterKey . '.stage', ['label' => __('Etapa'), 'empty' => __('--Todos--'), 'options' => StageField::toListLabel()]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $this->Form->control($filterKey . '.status', ['label' => __('Estado'), 'empty' => __('--Todos--'), 'options' => StageStatus::toListLabel()]) ?>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex">
            <div class="ml-auto">
                <?= $this->Button->search() ?>
                <?= $this->Button->export() ?>
                <?= $this->Button->cancel(['url' => ['action' => 'index']]) ?>
            </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>