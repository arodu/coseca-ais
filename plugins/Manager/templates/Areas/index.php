<?php

/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $areas
 */
?>
<?php
$this->assign('title', __('Areas'));
$this->assign('backUrl', $redirect ?? null);
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Areas')],
]);
?>

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
            <?= $this->Html->link(__('New Area'), ['action' => 'add'], ['class' => 'btn btn-primary btn-sm ml-2']) ?>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('logo') ?></th>
                    <th><?= $this->Paginator->sort('abbr') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($areas as $area) : ?>
                    <tr>
                        <td>
                            <?php if ($area->logo) : ?>
                                <?= $this->Html->image($area->logo, [
                                    'class' => 'img-fluid',
                                    'alt' => $area->name,
                                    'style' => 'max-width:30px;max-height:30px;'
                                ]) ?>
                            <?php endif ?>
                        </td>
                        <td><?= h($area->abbr) ?></td>
                        <td>
                            <?= $this->Html->link(
                                h($area->name),
                                ['action' => 'view', $area->id, '?' => ['redirect' => $this->getRequest()->getRequestTarget()]],
                            ) ?>
                        </td>
                        <td><?= h($area->created) ?></td>
                        <td><?= h($area->modified) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->

    <div class="card-footer d-flex flex-column flex-md-row">
        <div class="text-muted">
            <?= $this->Html->link(
                '<i class="fas fa-trash"></i> ',
                ['action' => 'trash'],
                [
                    'class' => 'btn btn-sm btn-outline-danger',
                    'escape' => false,
                    'title' => __('Ver elementos eliminados'),
                ]
            ) ?>

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