<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StudentStage $studentStage
 */
?>
<?php
$this->assign('title', __('Add Student Stage'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'List Student Stages', 'url' => ['action' => 'index']],
    ['title' => 'Add'],
]);
?>

<div class="card card-primary card-outline">
  <?= $this->Form->create($studentStage) ?>
  <div class="card-body">
    <?php
      echo $this->Form->control('student_id', ['options' => $students]);
      echo $this->Form->control('stage');
      echo $this->Form->control('lapse_id', ['options' => $lapses]);
      echo $this->Form->control('status');
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

