<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Student[]|\Cake\Collection\CollectionInterface $students
 */

use Cake\Core\Configure;

?>
<?php
$this->assign('title', __('Students'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => 'List Students'],
]);
?>

<?= $formFilters->render() ?>

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
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <?= $this->Form->create(null, ['url' => ['action' => 'bulkActions']]) ?>
        <table class="table table-striped table-hover text-nowrap institution-projects">
            <thead>
                <tr>
                    <th class="narrow"><?= $this->BulkAction->checkbox('all') ?></th>
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
                        <td><?= $this->BulkAction->checkbox('item', $student->id) ?></td>
                        <td><?= h($student->tenant->abbr_label) ?></td>
                        <td><?= h($student->dni) ?></td>
                        <td><?= h($student->first_name) ?></td>
                        <td><?= h($student->last_name) ?></td>
                        <td><?= h($student->lapse?->name) ?? $this->App->nan() ?></td>
                        <td>
                            <?= h($studentStage->stage_label) ?>
                            <?= $this->Html->tag(
                                'span',
                                $student->last_stage->status_label,
                                ['class' => [$studentStage->status_obj->color()->badge(), 'ml-2']]
                            ) ?>
                        </td>
                        <td class="project_progress">
                            <?= $this->App->progressBar($student->total_hours ?? 0, Configure::read('coseca.hours-min')) ?>
                        </td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $student->id], ['class' => 'btn btn-xs btn-outline-primary', 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="row mx-2 mb-2">
            <div class="col-12 col-md-6 col-xl-4">
                <div class="input-group">
                    <?= $this->BulkAction->selectActions([
                        'closeStageCourse' => __('Taller finalizado con exito'),
                    ]) ?>
                    <span class="input-group-append">
                        <?= $this->Form->button(__('Submit')) ?>
                    </span>
                </div>
            </div>
        </div>

        <?= $this->Form->end() ?>
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

<?= $this->BulkAction->scripts() ?>