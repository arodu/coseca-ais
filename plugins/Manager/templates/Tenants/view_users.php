<?php

/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $tenant
 */
?>

<?php
$this->assign('title', __('Tenant'));
$this->assign('backUrl', $redirect ?? null);
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Tenants'), 'url' => ['action' => 'index']],
    ['title' => __('View')],
]);
?>

<div class="view card card-primary card-outline">
    <div class="card-header d-sm-flex">
        <h2 class="card-title">
            <?= $this->Html->link(h($tenant->program->area->name), ['controller' => 'Areas', 'action' => 'view', $tenant->program->area->id, '?' => ['redirect' => $this->getRedirectUrl()]]) ?>
            |
            <?= $this->Html->link(h($tenant->program->name), ['controller' => 'Programs', 'action' => 'view', $tenant->program->id, '?' => ['redirect' => $this->getRedirectUrl()]]) ?>
            |
            <?= $this->Html->link(h($tenant->location->name), ['controller' => 'Locations', 'action' => 'view', $tenant->location->id, '?' => ['redirect' => $this->getRedirectUrl()]]) ?>
        </h2>
        <div class="ml-auto">
            <?= $this->Html->link(
                __('Agregar Usuario'),
                [
                    'action' => 'addUser',
                    '?' => ['tenant_id' => $tenant->id, 'redirect' => $this->getRedirectUrl()]
                ],
                ['class' => 'btn btn-primary btn-sm']
            ) ?>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <tr>
                <th><?= __('dni') ?></th>
                <th><?= __('first_name') ?></th>
                <th><?= __('last_name') ?></th>
                <th><?= __('email') ?></th>
                <th><?= __('active') ?></th>
                <th><?= __('role') ?></th>
                <th><?= __('last_login') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($tenant->tenant_filters as $tenantFilter) : ?>
                <?php $user = $tenantFilter->app_user; ?>
                <tr class="<?= $class ?? null ?>">
                    <td><?= h($user->dni) ?></td>
                    <td><?= h($user->first_name) ?></td>
                    <td><?= h($user->last_name) ?></td>
                    <td>
                        <?= h($user->email) ?>
                        <?php if ($user->id === $this->getIdentity()->getIdentifier()) : ?>
                            <i class="fas fa-star text-warning"></i>
                        <?php endif; ?>
                    </td>
                    <td><?= ($user->active) ? __('Yes') : __('No') ?></td>
                    <td><?= h($user->role) ?></td>
                    <td><?= h($user->last_login) ?></td>
                    <td class="actions">
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'deleteUser', $tenantFilter->id], ['class' => 'btn btn-xs btn-outline-danger', 'escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
