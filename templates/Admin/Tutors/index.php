<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tutor[]|\Cake\Collection\CollectionInterface $tutors
 */

use CakeLteTools\Utility\FaIcon;

?>
<?php
$this->assign('title', __('Tutors'));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Tutors')],
]);
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
    <div class="collapse <?= (($filtered ?? false) ? 'show' : null) ?>" id="collapse-filters">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <?= $this->Form->control('name', ['label' => __('Nombres/Apellidos')]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $this->Form->control('dni', ['label' => __('Cedula')]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $this->Form->control('tenant_id', ['options' => $tenants, 'label' => __('Programa'), 'empty' => __('--Todos--')]) ?>
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
            <?= $this->Html->link(__('New Tutor'), ['action' => 'add'], ['class' => 'btn btn-primary btn-sm ml-2']) ?>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th class='d-none d-sm-table-cell'><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th class='d-none d-sm-table-cell'><?= $this->Paginator->sort('dni') ?></th>
                    <th class='d-none d-lg-table-cell'><?= $this->Paginator->sort('phone') ?></th>
                    <th class='d-none d-xl-table-cell'><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('tenant_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tutors as $tutor) : ?>
                    <tr>
                        <td class='d-none d-sm-table-cell'><?= $this->Number->format($tutor->id) ?></td>
                        <td><?= h($tutor->name) ?></td>
                        <td class='d-none d-sm-table-cell'><?= h($tutor->dni) ?></td>
                        <td class='d-none d-lg-table-cell'><?= h($tutor->phone) ?></td>
                        <td class='d-none d-xl-table-cell'><?= h($tutor->email) ?></td>
                        <td><?= $tutor->has('tenant') ? $this->Html->link($tutor->tenant->label, ['controller' => 'Tenants', 'action' => 'view', $tutor->tenant->id]) : '' ?></td>
                        <td class="actions">
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="<?= 'ddActionTutors' . $tutor->id ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?= __("Acciones")?>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="<?= 'ddActionTutors' . $tutor->id ?>">
                                    <?= $this->Html->link(__('View'), ['action' => 'view', $tutor->id], ['class' => 'dropdown-item', 'escape' => false]) ?>
                                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $tutor->id], ['class' => 'dropdown-item', 'escape' => false]) ?>
                                    <?= $this->ModalForm->link(
                                        __('Delete'),
                                        ['action' => 'delete', $tutor->id],
                                        [
                                            'class' => 'dropdown-item',
                                            'escape' => false,
                                            'target' => 'deleteTutorModal',
                                            'confirm' => __('Are you sure you want to delete # {0}?', $tutor->id)
                                        ]
                                    ) ?>
                                    <?php // $this->Form->postLink(__('Delete'), ['action' => 'delete', $tutor->id], ['class' => 'btn btn-xs btn-outline-danger', 'escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $tutor->id)]) 
                                    ?>
                                </div>
                            </div>
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
    <!-- /.card-footer -->
</div>

<?php
echo  $this->ModalForm->modal('deleteTutorModal', [
    'element' => \ModalForm\ModalFormPlugin::FORM_TIMER,
    'content' => [
        'title' => __('Delete Tutor'),
        'confirm' => 'qwdqw112d12d12dqwdqwdqwd',
        'timer' => '3',
        'buttonOk'  => 'Enviar',
        //'buttonCancel'  => 'Cancelar',
    ]
]);
?>