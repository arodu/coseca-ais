<?php

/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $program
 */
?>

<?php
$this->assign('title', __('Program'));
$this->assign('backUrl', $redirect ?? $this->Url->build(['action' => 'index']));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Programs'), 'url' => ['action' => 'index']],
    ['title' => __('View')],
]);
?>

<div class="view card card-primary card-outline">
    <div class="card-header d-sm-flex">
        <h2 class="card-title"><?= h($program->name) ?></h2>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <tr>
                <th><?= __('Name') ?></th>
                <td><?= h($program->name) ?></td>
            </tr>
            <tr>
                <th><?= __('Regime') ?></th>
                <td><?= h($program->regime) ?></td>
            </tr>
            <tr>
                <th><?= __('Abbr') ?></th>
                <td><?= h($program->abbr) ?></td>
            </tr>
            <tr>
                <th><?= __('Area Id') ?></th>
                <td><?= $this->Html->link($program->area->name, [
                        'controller' => 'Areas',
                        'action' => 'view',
                        $program->area->id,
                        '?' => ['redirect' => $this->getRedirectUrl()]
                    ]) ?>
                </td>
            </tr>
            <tr>
                <th><?= __('Created') ?></th>
                <td><?= h($program->created) ?></td>
            </tr>
            <tr>
                <th><?= __('Modified') ?></th>
                <td><?= h($program->modified) ?></td>
            </tr>
        </table>
    </div>
    <div class="card-footer d-flex">
        <div class="">
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $program->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $program->id), 'class' => 'btn btn-danger']
            ) ?>
        </div>
        <div class="ml-auto">
            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $program->id], ['class' => 'btn btn-secondary']) ?>
            <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>

<div class="related related-tenants view card">
    <div class="card-header d-flex">
        <h3 class="card-title"><?= __('Sedes de {0}', $program->name) ?></h3>
        <div class="ml-auto">
            <?= $this->Html->link(
                __('New Tenant'),
                [
                    'controller' => 'Tenants',
                    'action' => 'add',
                    '?' => ['program_id' => $program->id, 'redirect' => $this->getRedirectUrl()]
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
                <th><?= __('Tipo') ?></th>
                <th><?= __('Activo') ?></th>
                <th class="actions"></th>
            </tr>
            <?php if (empty($program->tenants)) { ?>
                <tr>
                    <td colspan="5" class="text-muted">
                        <?= __('Locations not found!') ?>
                    </td>
                </tr>
            <?php } else { ?>
                <?php foreach ($program->tenants as $tenant) : ?>
                    <tr>
                        <td><?= h($tenant->location->abbr) ?></td>
                        <td>
                            <?= $this->Html->link(
                                h($tenant->location->name),
                                [
                                    'controller' => 'Locations',
                                    'action' => 'view',
                                    $tenant->location->id,
                                    '?' => ['redirect' => $this->getRedirectUrl()]
                                ]
                            ) ?>
                        </td>
                        <td><?= h($tenant->location->type_label) ?></td>
                        <td><?= $tenant->active ? __('Yes') : __('No') ?></td>
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
