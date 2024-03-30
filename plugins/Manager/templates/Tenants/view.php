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
    <h2 class="card-title"><?= h($tenant->id) ?></h2>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($tenant->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Program Id') ?></th>
            <td><?= $this->Number->format($tenant->program_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Location Id') ?></th>
            <td><?= $this->Number->format($tenant->location_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Active') ?></th>
            <td><?= $tenant->active ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
  </div>
  <div class="card-footer d-flex">
    <div class="">
      <?= $this->Form->postLink(
          __('Delete'),
          ['action' => 'delete', $tenant->id],
          ['confirm' => __('Are you sure you want to delete # {0}?', $tenant->id), 'class' => 'btn btn-danger']
      ) ?>
    </div>
    <div class="ml-auto">
      <?= $this->Html->link(__('Edit'), ['action' => 'edit', $tenant->id], ['class' => 'btn btn-secondary']) ?>
      <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
    </div>
  </div>
</div>


