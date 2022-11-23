<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Lapse $lapse
 */
?>
<?php
$this->assign('title', __('Add Lapse'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'List Lapses', 'url' => ['action' => 'index']],
    ['title' => 'Add'],
]);
?>

<div class="card card-primary card-outline">
  <?= $this->Form->create($lapse) ?>
  <div class="card-body">
    <?php
      echo $this->Form->control('name');
      echo $this->Form->control('active', ['custom' => true]);
      echo $this->Form->control('date');
      echo $this->Form->control('tenant_id', ['options' => $tenants]);
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

