<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Student[]|\Cake\Collection\CollectionInterface $students
 */

use App\Enum\FaIcon;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use Cake\Core\Configure;

?>
<?php
$this->assign('title', __('Students'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'List Students'],
]);
?>

<div class="card card-success card-outline">
    <div class="card-header d-flex flex-column flex-md-row">
        <h2 class="card-title w-100">
            <span class="d-flex w-100" data-toggle="collapse" href="#collapse-filters">
                <?= FaIcon::FILTER->render('fa-fw mr-2') ?>
                <?= __('Filtros') ?>
                <i class="icon-caret fas fa-caret-up ml-auto fa-fw"></i>
            </span>
        </h2>
    </div>
    <?= $this->Form->create() ?>
    <div class="collapse <?= $filtered ?? false ? 'show' : null ?>" id="collapse-filters">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <?= $this->QueryFilter->control('names', []) ?>
                </div>
                <div class="col-sm-4">
                    <?= $this->QueryFilter->control('dni') ?>
                </div>
                <div class="col-sm-4">
                    <?= $this->QueryFilter->control('tenant_id', ['empty' => __('Todos')]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= $this->QueryFilter->control('stage', ['empty' => true, 'options' => StageField::toListLabel()]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $this->QueryFilter->control('lapse', ['empty' => true, 'options' => []]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $this->QueryFilter->control('status', ['empty' => true, 'options' => StageStatus::toListLabel()]) ?>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex">
            <div class="ml-auto">
                <?= $this->Html->link(__('Reset'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Form->button(__('Buscar')) ?>
            </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>


<div class="card card-primary card-outline">
    <div class="card-header d-flex flex-column flex-md-row">
        <h2 class="card-title">
            <!-- -->
        </h2>
        <div class="d-flex ml-auto">
            <?= $this->Paginator->limitControl([], null, [
                'label' => false,
                'class' => 'form-control-sm',
                'templates' => ['inputContainer' => '{{content}}']
            ]); ?>
            <?php //echo $this->Html->link(__('New Student'), ['action' => 'add'], ['class' => 'btn btn-primary btn-sm ml-2']) 
            ?>
            <?php echo $this->Html->link(FaIcon::DOWNLOAD->render(), ['action' => 'index', '_ext' => 'csv'], ['class' => 'btn btn-primary btn-sm ml-2', 'escape' => false]) ?>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <table class="table table-striped table-hover text-nowrap projects">
            <thead>
                <tr>
                    <th class="narrow"><?= $this->Paginator->sort('Tenants.abbr', __('Programa')) ?></th>
                    <th><?= $this->Paginator->sort('dni', __('Cedula')) ?></th>
                    <th><?= $this->Paginator->sort('AppUsers.first_name', __('Nombres')) ?></th>
                    <th><?= $this->Paginator->sort('AppUsers.last_name', __('Apellidos')) ?></th>
                    <th><?= __('Lapso') ?></th>
                    <th><?= __('Etapa') ?></th>
                    <th style="width:20%;"><?= __('Horas') ?></th>
                    <th class="actions"><?= __('Acciones') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student) : ?>
                    <?php
                    $studentStage = $student->last_stage;
                    ?>
                    <tr>
                        <td><?= h($student->tenant->abbr) ?></td>
                        <td><?= h($student->dni) ?></td>
                        <td><?= h($student->first_name) ?></td>
                        <td><?= h($student->last_name) ?></td>
                        <td><?= h($studentStage->lapse->name) ?></td>
                        <td>
                            <?= h($studentStage->stage_label) ?>
                            <?= $this->Html->tag(
                                'span',
                                $student->last_stage->status_label,
                                ['class' => [$studentStage->getStatus()->color()->cssClass('badge'), 'ml-2']]
                            ) ?>
                        </td>
                        <td class="project_progress">
                            <?= $this->App->progressBar(rand(0, 130), Configure::read('coseca.hours-min')) ?>
                        </td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $student->id], ['class' => 'btn btn-xs btn-outline-primary', 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->

    <div class="card-footer d-flex flex-column flex-md-row">
        <div class="text-muted">
            <?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
        </div>
        <ul class="pagination pagination-sm mb-0 ml-auto">
            <?= $this->Paginator->first('<i class="fas fa-angle-double-left"></i>', ['escape' => false]) ?>
            <?= $this->Paginator->prev('<i class="fas fa-angle-left"></i>', ['escape' => false]) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('<i class="fas fa-angle-right"></i>', ['escape' => false]) ?>
            <?= $this->Paginator->last('<i class="fas fa-angle-double-right"></i>', ['escape' => false]) ?>
        </ul>
    </div>
</div>