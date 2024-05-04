<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Student[]|\Cake\Collection\CollectionInterface $students
 */

use CakeLteTools\Utility\FaIcon;

?>
<?php
$this->assign('title', __('Students'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Estudiantes')],
]);
?>

<style>
    @media (max-width: 1270px) {
        responsive-hide: {
            width: 0;
            visibility: hidden;
            overflow: hidden;
            white-space: nowrap;
        }
    }
</style>

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
    <div class="card-body table-responsive-sm p-0">
        <?= $this->Form->create(null, ['url' => ['action' => 'bulkActions']]) ?>
        <table class="table table-hover text-nowrap institution-projects">
            <thead>
                <tr>
                    <th class='d-none d-sm-table-cell'><?= $this->BulkAction->checkboxAll('all') ?></th>
                    <th><?= $this->Paginator->sort('Tenants.abbr', __('Programa')) ?></th>
                    <th colspan="3">
                        <span><?= $this->Paginator->sort('AppUsers.dni', __('Cedula')) ?></span>
                        <span class="ml-3"><?= $this->Paginator->sort('AppUsers.first_name', __('Nombres'), ['class' => 'ml-2']) ?></span>
                        <span class="ml-3"><?= $this->Paginator->sort('AppUsers.last_name', __('Apellidos')) ?></span>
                    </th>
                    <th class='d-none d-xl-table-cell'><?= __('Lapso') ?></th>
                    <th class='d-none d-xl-table-cell'><?= __('Estatus') ?></th>
                    <th class='d-none d-xl-table-cell'><?= __('Etapa') ?></th>
                    <th style="width:20%;" class='d-none d-md-table-cell'><?= __('Horas') ?></th>
                    <th class="actions d-none d-sm-table-cell"><?= __('Acciones') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student) : ?>
                    <?php
                    $studentStage = $student->last_stage;
                    ?>
                    <tr>
                        <td class='d-none d-sm-table-cell'><?= $this->BulkAction->checkbox('item', ['value' => $student->id]) ?></td>
                        <td><?= h($student->tenant->abbr_label) ?></td>
                        <td colspan=3>
                            <?= $this->Html->link(
                                FaIcon::get('user', 'fa-fw mr-1') . ' ' . __('{0}, {1} {2}', h($student->dni), h($student->last_name), h($student->first_name)),
                                ['_name' => 'admin:student:view', $student->id],
                                ['escape' => false]
                            ) ?>
                        </td>
                        <td class='d-none d-xl-table-cell'><?= h($student->lapse?->name) ?? $this->App->nan() ?></td>
                        <td class='d-none d-xl-table-cell'><?= $this->App->badge($student->getActive()) ?></td>
                        <td class='d-none d-xl-table-cell'>
                            <?= h($studentStage->stage_label) ?>
                            <?= $this->App->badge($studentStage->enum('status')) ?>
                        </td>
                        <td class="project_progress d-none d-md-table-cell">
                            <?= $this->App->progressBar($student->total_hours ?? 0) ?>
                        </td>
                        <td class="actions d-none d-sm-table-cell">
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="<?= 'ddActionStudent' . $student->id ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Acciones
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="<?= 'ddActionStudent' . $student->id ?>">
                                    <?= $this->Html->link(__('Ver'), ['_name' => 'admin:student:view', $student->id], ['class' => 'dropdown-item']) ?>
                                    <?= $this->Html->link(__('Proyectos'), ['_name' => 'admin:student:adscriptions', $student->id], ['class' => 'dropdown-item']) ?>
                                    <?= $this->Html->link(__('Actividades'), ['_name' => 'admin:student:tracking', $student->id], ['class' => 'dropdown-item']) ?>
                                    <div class="dropdown-divider"></div>
                                    <?= $this->Html->link(__('Planillas'), ['_name' => 'admin:student:prints', $student->id], ['class' => 'dropdown-item']) ?>
                                </div>
                            </div>
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
