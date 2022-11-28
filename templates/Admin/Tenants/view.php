<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tenant $tenant
 */
?>

<?php
$this->assign('title', __('Tenant'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'List Tenants', 'url' => ['action' => 'index']],
    ['title' => 'View'],
]);
?>

<div class="view card card-primary card-outline">
  <div class="card-header d-sm-flex">
    <h2 class="card-title"><?= h($tenant->name) ?></h2>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($tenant->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Abbr') ?></th>
            <td><?= h($tenant->abbr) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($tenant->id) ?></td>
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


<div class="related related-lapses view card">
  <div class="card-header d-flex">
    <h3 class="card-title"><?= __('Related Lapses') ?></h3>
    <div class="ml-auto">
      <?= $this->Html->link(__('New'), ['controller' => 'Lapses' , 'action' => 'add'], ['class' => 'btn btn-primary btn-sm']) ?>
      <?= $this->Html->link(__('List '), ['controller' => 'Lapses' , 'action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
    </div>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
      <tr>
          <th><?= __('Id') ?></th>
          <th><?= __('Name') ?></th>
          <th><?= __('Active') ?></th>
          <th><?= __('Date') ?></th>
          <th><?= __('Tenant Id') ?></th>
          <th class="actions"><?= __('Actions') ?></th>
      </tr>
      <?php if (empty($tenant->lapses)) { ?>
        <tr>
            <td colspan="6" class="text-muted">
              Lapses record not found!
            </td>
        </tr>
      <?php }else{ ?>
        <?php foreach ($tenant->lapses as $lapses) : ?>
        <tr>
            <td><?= h($lapses->id) ?></td>
            <td><?= h($lapses->name) ?></td>
            <td><?= h($lapses->active) ?></td>
            <td><?= h($lapses->date) ?></td>
            <td><?= h($lapses->tenant_id) ?></td>
            <td class="actions">
              <?= $this->Html->link(__('View'), ['controller' => 'Lapses', 'action' => 'view', $lapses->id], ['class'=>'btn btn-xs btn-outline-primary']) ?>
              <?= $this->Html->link(__('Edit'), ['controller' => 'Lapses', 'action' => 'edit', $lapses->id], ['class'=>'btn btn-xs btn-outline-primary']) ?>
              <?= $this->Form->postLink(__('Delete'), ['controller' => 'Lapses', 'action' => 'delete', $lapses->id], ['class'=>'btn btn-xs btn-outline-danger', 'confirm' => __('Are you sure you want to delete # {0}?', $lapses->id)]) ?>
            </td>
        </tr>
        <?php endforeach; ?>
      <?php } ?>
    </table>
  </div>
</div>

<div class="related related-students view card">
  <div class="card-header d-flex">
    <h3 class="card-title"><?= __('Related Students') ?></h3>
    <div class="ml-auto">
      <?= $this->Html->link(__('New'), ['controller' => 'Students' , 'action' => 'add'], ['class' => 'btn btn-primary btn-sm']) ?>
      <?= $this->Html->link(__('List '), ['controller' => 'Students' , 'action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
    </div>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
      <tr>
          <th><?= __('Id') ?></th>
          <th><?= __('User Id') ?></th>
          <th><?= __('Tenant Id') ?></th>
          <th><?= __('Type') ?></th>
          <th><?= __('Dni') ?></th>
          <th><?= __('Created') ?></th>
          <th><?= __('Created By') ?></th>
          <th><?= __('Modified') ?></th>
          <th><?= __('Modified By') ?></th>
          <th><?= __('Gender') ?></th>
          <th><?= __('Phone') ?></th>
          <th><?= __('Address') ?></th>
          <th><?= __('Current Semester') ?></th>
          <th><?= __('Uc') ?></th>
          <th><?= __('Areas') ?></th>
          <th><?= __('Observations') ?></th>
          <th class="actions"><?= __('Actions') ?></th>
      </tr>
      <?php if (empty($tenant->students)) { ?>
        <tr>
            <td colspan="17" class="text-muted">
              Students record not found!
            </td>
        </tr>
      <?php }else{ ?>
        <?php foreach ($tenant->students as $students) : ?>
        <tr>
            <td><?= h($students->id) ?></td>
            <td><?= h($students->user_id) ?></td>
            <td><?= h($students->tenant_id) ?></td>
            <td><?= h($students->type) ?></td>
            <td><?= h($students->dni) ?></td>
            <td><?= h($students->created) ?></td>
            <td><?= h($students->created_by) ?></td>
            <td><?= h($students->modified) ?></td>
            <td><?= h($students->modified_by) ?></td>
            <td><?= h($students->gender) ?></td>
            <td><?= h($students->phone) ?></td>
            <td><?= h($students->address) ?></td>
            <td><?= h($students->current_semester) ?></td>
            <td><?= h($students->uc) ?></td>
            <td><?= h($students->areas) ?></td>
            <td><?= h($students->observations) ?></td>
            <td class="actions">
              <?= $this->Html->link(__('View'), ['controller' => 'Students', 'action' => 'view', $students->id], ['class'=>'btn btn-xs btn-outline-primary']) ?>
              <?= $this->Html->link(__('Edit'), ['controller' => 'Students', 'action' => 'edit', $students->id], ['class'=>'btn btn-xs btn-outline-primary']) ?>
              <?= $this->Form->postLink(__('Delete'), ['controller' => 'Students', 'action' => 'delete', $students->id], ['class'=>'btn btn-xs btn-outline-danger', 'confirm' => __('Are you sure you want to delete # {0}?', $students->id)]) ?>
            </td>
        </tr>
        <?php endforeach; ?>
      <?php } ?>
    </table>
  </div>
</div>

<div class="related related-tenantFilters view card">
  <div class="card-header d-flex">
    <h3 class="card-title"><?= __('Related Tenant Filters') ?></h3>
    <div class="ml-auto">
      <?= $this->Html->link(__('New'), ['controller' => 'TenantFilters' , 'action' => 'add'], ['class' => 'btn btn-primary btn-sm']) ?>
      <?= $this->Html->link(__('List '), ['controller' => 'TenantFilters' , 'action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
    </div>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
      <tr>
          <th><?= __('Id') ?></th>
          <th><?= __('User Id') ?></th>
          <th><?= __('Tenant Id') ?></th>
          <th><?= __('Created') ?></th>
          <th class="actions"><?= __('Actions') ?></th>
      </tr>
      <?php if (empty($tenant->tenant_filters)) { ?>
        <tr>
            <td colspan="5" class="text-muted">
              Tenant Filters record not found!
            </td>
        </tr>
      <?php }else{ ?>
        <?php foreach ($tenant->tenant_filters as $tenantFilters) : ?>
        <tr>
            <td><?= h($tenantFilters->id) ?></td>
            <td><?= h($tenantFilters->user_id) ?></td>
            <td><?= h($tenantFilters->tenant_id) ?></td>
            <td><?= h($tenantFilters->created) ?></td>
            <td class="actions">
              <?= $this->Html->link(__('View'), ['controller' => 'TenantFilters', 'action' => 'view', $tenantFilters->id], ['class'=>'btn btn-xs btn-outline-primary']) ?>
              <?= $this->Html->link(__('Edit'), ['controller' => 'TenantFilters', 'action' => 'edit', $tenantFilters->id], ['class'=>'btn btn-xs btn-outline-primary']) ?>
              <?= $this->Form->postLink(__('Delete'), ['controller' => 'TenantFilters', 'action' => 'delete', $tenantFilters->id], ['class'=>'btn btn-xs btn-outline-danger', 'confirm' => __('Are you sure you want to delete # {0}?', $tenantFilters->id)]) ?>
            </td>
        </tr>
        <?php endforeach; ?>
      <?php } ?>
    </table>
  </div>
</div>

