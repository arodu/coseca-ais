<?php

/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $location
 */
?>

<?php
$this->assign('title', __('Location'));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Locations'), 'url' => ['action' => 'index']],
    ['title' => __('View')],
]);
?>

<div class="view card card-primary card-outline">
    <div class="card-header d-sm-flex">
        <h2 class="card-title"><?= h($location->name) ?></h2>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <tr>
                <th><?= __('Name') ?></th>
                <td><?= h($location->name) ?></td>
            </tr>
            <tr>
                <th><?= __('Abbr') ?></th>
                <td><?= h($location->abbr) ?></td>
            </tr>
            <tr>
                <th><?= __('Type') ?></th>
                <td><?= h($location->type_label) ?></td>
            </tr>
            <tr>
                <th><?= __('Created') ?></th>
                <td><?= h($location->created) ?></td>
            </tr>
            <tr>
                <th><?= __('Modified') ?></th>
                <td><?= h($location->modified) ?></td>
            </tr>
        </table>
    </div>
    <div class="card-footer d-flex">
        <div class="">
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $location->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $location->id), 'class' => 'btn btn-danger']
            ) ?>
        </div>
        <div class="ml-auto">
            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $location->id], ['class' => 'btn btn-secondary']) ?>
            <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>



<div class="related related-programs view card">
    <div class="card-header d-flex">
        <h3 class="card-title"><?= __('Programas en {0}', $location->name) ?></h3>
        <div class="ml-auto">
            <?= $this->Html->link(
                __('New Tenant'),
                [
                    'controller' => 'Tenants',
                    'action' => 'add',
                    '?' => ['location_id' => $location->id, 'redirect' => $this->getRedirectUrl()]
                ],
                ['class' => 'btn btn-xs btn-primary']
            ) ?>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <tr>
                <th><?= __('Abbr') ?></th>
                <th><?= __('Nombre') ?></th>
                <th><?= __('Regimen') ?></th>
                <th><?= __('Area') ?></th>
                <th><?= __('Activo') ?></th>
                <th><?= __('Creado') ?></th>
                <th><?= __('Modificado') ?></th>
                <th class="actions"></th>
            </tr>
            <?php if (empty($location->tenants)) { ?>
                <tr>
                    <td colspan="4" class="text-muted">
                        <?= __('Programs not found!') ?>
                    </td>
                </tr>
            <?php } else { ?>
                <?php foreach ($location->tenants as $tenant) : ?>
                    <tr>
                        <td><?= h($tenant->program->abbr) ?></td>
                        <td>
                            <?= $this->Html->link(
                                h($tenant->program->name),
                                [
                                    'controller' => 'Programs',
                                    'action' => 'view',
                                    $tenant->program->id,
                                    '?' => ['redirect' => $this->getRedirectUrl()]
                                ]
                            ) ?>
                        </td>
                        <td><?= h($tenant->program->regime_label) ?></td>
                        <td>
                            <?= $this->Html->link(
                                h($tenant->program->area->abbr),
                                [
                                    'controller' => 'Areas',
                                    'action' => 'view',
                                    $tenant->program->area->id,
                                    '?' => ['redirect' => $this->getRedirectUrl()]
                                ]
                            ) ?>
                        </td>
                        <td><?= $tenant->active ? __('Yes') : __('No') ?></td>
                        <td><?= h($tenant->created) ?></td>
                        <td><?= h($tenant->modified) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(
                                __('Editar'),
                                [
                                    'controller' => 'Tenants',
                                    'action' => 'edit',
                                    $tenant->id,
                                    '?' => ['redirect' => $this->getRedirectUrl()]
                                ],
                                [
                                    'class' => 'btn btn-xs btn-outline-primary'
                                ]
                            ) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php } ?>
        </table>
    </div>
</div>