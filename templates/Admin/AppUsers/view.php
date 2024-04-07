<?php

/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $user
 * @var \App\Model\Entity\AppUser $user
 */
?>

<?php
$this->assign('title', __('User'));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Users'), 'url' => ['action' => 'index']],
    ['title' => __('View')],
]);
?>

<div class="view card card-primary card-outline">
    <div class="card-header d-sm-flex">
        <h2 class="card-title">
            <?= h($user->username) ?>
            <?= $this->App->currentUserIcon($user->id) ?>
        </h2>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <tr>
                <th><?= __('Email') ?></th>
                <td><?= h($user->email) ?></td>
            </tr>
            <tr>
                <th><?= __('Dni') ?></th>
                <td><?= h($user->dni) ?></td>
            </tr>
            <tr>
                <th><?= __('First Name') ?></th>
                <td><?= h($user->first_name) ?></td>
            </tr>
            <tr>
                <th><?= __('Last Name') ?></th>
                <td><?= h($user->last_name) ?></td>
            </tr>
            <tr>
                <th><?= __('Role') ?></th>
                <td><?= $user->enum('role')->label() ?></td>
            </tr>
            <tr>
                <th><?= __('Created') ?></th>
                <td><?= h($user->created) ?></td>
            </tr>
            <tr>
                <th><?= __('Modified') ?></th>
                <td><?= h($user->modified) ?></td>
            </tr>
            <tr>
                <th><?= __('Last Login') ?></th>
                <td><?= h($user->last_login) ?></td>
            </tr>
            <tr>
                <th><?= __('Active') ?></th>
                <td><?= $user->active ? __('Yes') : __('No'); ?></td>
            </tr>
        </table>
    </div>
    <div class="card-footer d-flex">
        <div class="">
        </div>
        <div class="ml-auto">
            <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>

<div class="related related-tenantFilters view card">
    <div class="card-header d-flex">
        <h3 class="card-title"><?= __('Related Tenant Filters') ?></h3>
        <div class="ml-auto">
            <?= $this->Html->link(
                __('Agregar Sede'),
                [
                    'controller' => 'Tenants',
                    'action' => 'addUser',
                    '?' => ['user_id' => $user->id, 'redirect' => $this->getRedirectUrl()]
                ],
                ['class' => 'btn btn-primary btn-sm']
            ) ?>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <tr>
                <th><?= __('Sede') ?></th>
                <th><?= __('Created') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php if (empty($user->tenant_filters)) { ?>
                <tr>
                    <td colspan="5" class="text-muted">
                        <?= __('Tenant Filters record not found!') ?>
                    </td>
                </tr>
            <?php } else { ?>
                <?php foreach ($user->tenant_filters as $tenantFilters) : ?>
                    <tr>
                        <td><?= h($tenantFilters->tenant->label) ?></td>
                        <td><?= h($tenantFilters->created) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(
                                __('Editar'),
                                ['controller' => 'Tenants', 'action' => 'editUser', $tenantFilters->id, '?' => ['redirect' => $this->getRedirectUrl()]],
                                ['class' => 'btn btn-xs btn-outline-primary']
                            ) ?>
                            <?= $this->Form->postLink(
                                __('Delete'),
                                ['controller' => 'Tenants', 'action' => 'deleteUser', $tenantFilters->id, '?' => ['redirect' => $this->getRedirectUrl()]],
                                ['class' => 'btn btn-xs btn-outline-danger', 'confirm' => __('Are you sure you want to delete # {0}?', $tenantFilters->id)]
                            ) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php } ?>
        </table>
    </div>
</div>