<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Student $student
 */
?>
<?php
$this->assign('title', __('Add Student'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'List Students', 'url' => ['action' => 'index']],
    ['title' => 'Add'],
]);
?>

<div class="card card-primary card-outline">
  <?= $this->Form->create($student) ?>
  <div class="card-body">
    <?php
      echo $this->Form->control('user_id', ['options' => $appUsers]);
      echo $this->Form->control('dni');
      echo $this->Form->control('created_by');
      echo $this->Form->control('modified_by');
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

