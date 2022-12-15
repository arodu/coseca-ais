<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tutor[]|\Cake\Collection\CollectionInterface $tutors
 */
?>
<?php
$this->assign('title', __('Tutors'));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Tutors')],
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
            <?= $this->Html->link(__('New Tutor'), ['action' => 'add'], ['class' => 'btn btn-primary btn-sm ml-2']) ?>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('dni') ?></th>
                    <th><?= $this->Paginator->sort('phone') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('tenant_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tutors as $tutor) : ?>
                    <tr>
                        <td><?= $this->Number->format($tutor->id) ?></td>
                        <td><?= h($tutor->name) ?></td>
                        <td><?= h($tutor->dni) ?></td>
                        <td><?= h($tutor->phone) ?></td>
                        <td><?= h($tutor->email) ?></td>
                        <td><?= $tutor->has('tenant') ? $this->Html->link($tutor->tenant->name, ['controller' => 'Tenants', 'action' => 'view', $tutor->tenant->id]) : '' ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $tutor->id], ['class' => 'btn btn-xs btn-outline-primary', 'escape' => false]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $tutor->id], ['class' => 'btn btn-xs btn-outline-primary', 'escape' => false]) ?>
                            <?= $this->ModalForm->link(
                                __('Delete'),
                                ['action' => 'delete', $tutor->id],
                                [
                                    'class' => 'btn btn-xs btn-outline-danger',
                                    'escape' => false,
                                    'target' => 'deleteTutorModal',
                                    'confirm' => __('Are you sure you want to delete # {0}?', $tutor->id)
                                ]
                            ) ?>
                            <?php // $this->Form->postLink(__('Delete'), ['action' => 'delete', $tutor->id], ['class' => 'btn btn-xs btn-outline-danger', 'escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $tutor->id)]) 
                            ?>
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

<?= $this->ModalForm->addModal('deleteTutorModal', [
    //'element' => \ModalForm\ModalFormPlugin::FORM_CONFIRM,
    'element' => \ModalForm\ModalFormPlugin::FORM_TEXT_INPUT,
    'title' => __('Delete Tutor'),
    'content' => [
        'confirm' => 'asdas',
    //    'textTemplate' => __('Please type :text to confirm.'),
    ]
]) ?>