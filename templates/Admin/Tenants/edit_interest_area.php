<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InterestArea $interestArea
 */
?>
<?php
$this->assign('title', __('Edit Interest Area'));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Interest Areas'), 'url' => ['action' => 'index']],
    ['title' => __('View'), 'url' => ['action' => 'view', $interestArea->id]],
    ['title' => __('Edit')],
]);
?>

<div class="card card-primary card-outline">
  <?= $this->Form->create($interestArea) ?>
  <div class="card-body">
    <?php
      echo $this->Form->control('program', ['value' => $program->name, 'readonly' => true]);
      echo $this->Form->control('name');
      echo $this->Form->control('description');
      echo $this->Form->control('active', ['custom' => true]);
    ?>
  </div>

  <div class="card-footer d-flex">
    <div></div>
    <div class="ml-auto">
      <?= $this->Form->button(__('Save')) ?>
      <?= $this->Html->link(__('Cancel'), ['action' => 'viewProgram', $program->id], ['class' => 'btn btn-default']) ?>

    </div>
  </div>

  <?= $this->Form->end() ?>
</div>

