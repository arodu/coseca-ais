<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Institution $institution
 */
?>

<?php
$this->assign('title', __('Institution'));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Institutions'), 'url' => ['action' => 'index']],
    ['title' => __('View')],
]);
?>

<div class="view card card-primary card-outline">
    <div class="card-header d-sm-flex">
        <h2 class="card-title"><?= h($institution->name) ?></h2>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <tr>
                <th><?= __('Contact Person') ?></th>
                <td><?= h($institution->contact_person) ?></td>
            </tr>
            <tr>
                <th><?= __('Contact Phone') ?></th>
                <td><?= h($institution->contact_phone) ?></td>
            </tr>
            <tr>
                <th><?= __('Contact Email') ?></th>
                <td><?= h($institution->contact_email) ?></td>
            </tr>
            <tr>
                <th><?= __('Programa') ?></th>
                <td><?= h($institution->tenant->label) ?></td>
            </tr>
            <tr>
                <th><?= __('Active') ?></th>
                <td><?= $institution->active ? __('Yes') : __('No'); ?></td>
            </tr>
            <tr>
                <th><?= __('Estado') ?></th>
                <td><?= h($institution?->state?->name) ?? $this->App->nan() ?></td>
            </tr>
            <tr>
                <th><?= __('Municipio') ?></th>
                <td><?= h($institution?->municipality?->name) ?? $this->App->nan() ?></td>
            </tr>
            <tr>
                <th><?= __('Parriquia') ?></th>
                <td><?= h($institution?->parish?->name) ?? $this->App->nan() ?></td>
            </tr>
        </table>
    </div>
    <div class="card-footer d-flex">
        <div>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $institution->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $institution->id), 'class' => 'btn btn-danger']
            ) ?>
        </div>
        <div class="ml-auto">
            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $institution->id], ['class' => 'btn btn-secondary']) ?>
            <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>


<div class="related related-institution-projects view card">
    <div class="card-header d-flex">
        <h3 class="card-title"><?= __('Proyectos') ?></h3>
        <div class="ml-auto">
            <?= $this->Html->link(__('Agregar Proyecto'), ['controller' => 'Institutions', 'action' => 'addProject', $institution->id], ['class' => 'btn btn-primary btn-sm']) ?>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <tr>
                <th><?= __('Proyecto') ?></th>
                <th><?= __('Activo') ?></th>
                <th><?= __('Area de Interes')?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php if (empty($institution->institution_projects)) { ?>
                <tr>
                    <td colspan="5" class="text-muted">
                        Institution Projects record not found!
                    </td>
                </tr>
            <?php } else { ?>
                <?php foreach ($institution->institution_projects as $institution_project) : ?>
                    <tr>
                        <td><?= h($institution_project->name) ?></td>
                        <td><?= $institution_project->active ? __('Yes') : __('No'); ?></td>
                        <td><?= h($institution_project->interest_area?->name) ?? $this->App->nan() ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('Edit'), ['controller' => 'Institutions', 'action' => 'editProject', $institution_project->id], ['class' => 'btn btn-xs btn-outline-primary']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php } ?>
        </table>
    </div>
</div>