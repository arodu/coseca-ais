<?php

/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $users
 */
?>
<?php
$this->assign('title', __('Users'));
$this->assign('backUrl', $redirect ?? null);
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Users')],
]);
?>

<div class="card card-primary card-outline">
    <div class="card-header d-flex flex-column flex-md-row">
        <div>
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <?= $this->Html->link(__('Staff'), ['action' => 'index', '?' => ['group' => 'staff']], ['class' => 'nav-link' . ($group === 'staff' ? ' active' : '')]) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Students'), ['action' => 'index', '?' => ['group' => 'student']], ['class' => 'nav-link' . ($group === 'student' ? ' active' : '')]) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('All'), ['action' => 'index', '?' => ['group' => 'all']], ['class' => 'nav-link' . ($group === 'all' ? ' active' : '')]) ?>
                </li>
            </ul>
        </div>
        <div class="d-flex ml-auto">
            <?= $this->Paginator->limitControl([], null, [
                'label' => false,
                'class' => 'form-control-sm',
                'templates' => ['inputContainer' => '{{content}}']
            ]); ?>
            <div>
                <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'btn btn-primary btn-sm ml-2']) ?>
            </div>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('email', __('Email')) ?></th>
                    <th><?= $this->Paginator->sort('dni', __('Cedula')) ?></th>
                    <th><?= $this->Paginator->sort('first_name', __('Nombres')) ?></th>
                    <th><?= $this->Paginator->sort('last_name', __('Apellidos')) ?></th>
                    <th><?= $this->Paginator->sort('active', __('Activo')) ?></th>
                    <th><?= $this->Paginator->sort('role', __('Rol')) ?></th>
                    <th><?= $this->Paginator->sort('last_login', __('Última sesión')) ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td>
                            <?= $this->Html->link(h($user->email), ['action' => 'view', $user->id]) ?>
                            <?php if ($user->id === $this->getIdentity()->getIdentifier()) : ?>
                                <i class="fas fa-star text-warning" title="<?= __('current user') ?>"></i>
                            <?php endif; ?>
                        </td>
                        <td><?= h($user->dni) ?></td>
                        <td><?= h($user->first_name) ?></td>
                        <td><?= h($user->last_name) ?></td>
                        <td><?= ($user->active) ? __('Yes') : __('No') ?></td>
                        <td><?= h($user->role) ?></td>
                        <td><?= h($user->last_login) ?></td>
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