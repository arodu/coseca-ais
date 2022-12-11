<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Institution $institution
 */
?>
<?php
$this->assign('title', __('Add Institution'));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Institutions'), 'url' => ['action' => 'index']],
    ['title' => __('Add')],
]);
?>

<div class="card card-primary card-outline">
  <?= $this->Form->create($institution) ?>
  <div class="card-body">
    <?php
      echo $this->Form->control('name');
      echo $this->Form->control('active', ['custom' => true]);
      echo $this->Form->control('contact_person');
      echo $this->Form->control('contact_phone');
      echo $this->Form->control('contact_email');
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

