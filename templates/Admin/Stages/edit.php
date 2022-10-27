<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Stage $stage
 */
?>
<?php
$this->assign('title', __('Edit Stage'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'List Stages', 'url' => ['action' => 'index']],
    ['title' => 'View', 'url' => ['action' => 'view', $stage->id]],
    ['title' => 'Edit'],
]);
?>

<div class="card card-primary card-outline">
  <?= $this->Form->create($stage) ?>
  <div class="card-body">
    <?php
      echo $this->Form->control('name');
      echo $this->Form->control('position');
      echo $this->Form->control('active', ['custom' => true]);
      echo $this->Form->control('code');
    ?>
  </div>

  <div class="card-footer d-flex">
    <div class="">
      <?= $this->Form->postLink(
          __('Delete'),
          ['action' => 'delete', $stage->id],
          ['confirm' => __('Are you sure you want to delete # {0}?', $stage->id), 'class' => 'btn btn-danger']
      ) ?>
    </div>
    <div class="ml-auto">
      <?= $this->Form->button(__('Save')) ?>
      <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
    </div>
  </div>

  <?= $this->Form->end() ?>
</div>

