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
            <th><?= __('Name') ?></th>
            <td><?= h($institution->name) ?></td>
        </tr>
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
            <th><?= __('Tenant') ?></th>
            <td><?= $institution->has('tenant') ? $this->Html->link($institution->tenant->name, ['controller' => 'Tenants', 'action' => 'view', $institution->tenant->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($institution->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Active') ?></th>
            <td><?= $institution->active ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
  </div>
  <div class="card-footer d-flex">
    <div class="">
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
    <h3 class="card-title"><?= __('Related Institution Projects') ?></h3>
    <div class="ml-auto">
      <?= $this->Html->link(__('New'), ['controller' => 'InstitutionProjects' , 'action' => 'add'], ['class' => 'btn btn-primary btn-sm']) ?>
      <?= $this->Html->link(__('List '), ['controller' => 'InstitutionProjects' , 'action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
    </div>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
      <tr>
          <th><?= __('Id') ?></th>
          <th><?= __('Institution Id') ?></th>
          <th><?= __('Name') ?></th>
          <th><?= __('Active') ?></th>
          <th class="actions"><?= __('Actions') ?></th>
      </tr>
      <?php if (empty($institution->institution_projects)) { ?>
        <tr>
            <td colspan="5" class="text-muted">
              Institution Projects record not found!
            </td>
        </tr>
      <?php }else{ ?>
        <?php foreach ($institution->institution_projects as $institution_project) : ?>
        <tr>
            <td><?= h($institution_project->id) ?></td>
            <td><?= h($institution_project->institution_id) ?></td>
            <td><?= h($institution_project->name) ?></td>
            <td><?= h($institution_project->active) ?></td>
            <td class="actions">
              <?= $this->Html->link(__('View'), ['controller' => 'InstitutionProjects', 'action' => 'view', $institution_project->id], ['class'=>'btn btn-xs btn-outline-primary']) ?>
              <?= $this->Html->link(__('Edit'), ['controller' => 'InstitutionProjects', 'action' => 'edit', $institution_project->id], ['class'=>'btn btn-xs btn-outline-primary']) ?>
              <?= $this->Form->postLink(__('Delete'), ['controller' => 'InstitutionProjects', 'action' => 'delete', $institution_project->id], ['class'=>'btn btn-xs btn-outline-danger', 'confirm' => __('Are you sure you want to delete # {0}?', $institution_project->id)]) ?>
            </td>
        </tr>
        <?php endforeach; ?>
      <?php } ?>
    </table>
  </div>
</div>

