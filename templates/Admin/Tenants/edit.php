<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tenant $tenant
 */
?>
<?php
$this->assign('title', __('Edit Tenant'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'List Tenants', 'url' => ['action' => 'index']],
    ['title' => 'View', 'url' => ['action' => 'view', $tenant->id]],
    ['title' => 'Edit'],
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
    <div class="">
      <?= $this->Form->postLink(
          __('Delete'),
          ['action' => 'delete', $tenant->id],
          ['confirm' => __('Are you sure you want to delete # {0}?', $tenant->id), 'class' => 'btn btn-danger']
      ) ?>
    </div>
    <div class="ml-auto">
      <?= $this->Form->button(__('Save')) ?>
      <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
    </div>
  </div>

  <?= $this->Form->end() ?>
</div>

