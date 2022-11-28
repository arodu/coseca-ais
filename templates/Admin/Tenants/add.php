<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tenant $tenant
 */
?>
<?php
$this->assign('title', __('Add Tenant'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'List Tenants', 'url' => ['action' => 'index']],
    ['title' => 'Add'],
]);
?>

<div class="card card-primary card-outline">
  <?= $this->Form->create($tenant) ?>
  <div class="card-body">
    <?php
      echo $this->Form->control('name');
      echo $this->Form->control('abbr');
      echo $this->Form->control('active', ['custom' => true]);
    ?>
  </div>

  <div class="card-footer d-flex">
    <div class="ml-auto">
      <?= $this->Form->button(__('Save')) ?>
      <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
    </div>
  </div>

  <?= $this->Form->end() ?>
</div>

