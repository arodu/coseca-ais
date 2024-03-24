<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $program
 */
?>
<?php
$this->assign('title', __('Edit Program'));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Programs'), 'url' => ['action' => 'index']],
    ['title' => __('View'), 'url' => ['action' => 'view', $program->id]],
    ['title' => __('Edit')],
]);
?>

<div class="card card-primary card-outline">
  <?= $this->Form->create($program) ?>
  <div class="card-body">
    <?php
      echo $this->Form->control('name');
      echo $this->Form->control('regime');
      echo $this->Form->control('abbr');
      echo $this->Form->control('area_id');
      echo $this->Form->control('created_by');
      echo $this->Form->control('modified_by');
      echo $this->Form->control('deleted', ['empty' => true]);
      echo $this->Form->control('deleted_by');
    ?>
  </div>

  <div class="card-footer d-flex">
    <div class="">
      <?= $this->Form->postLink(
          __('Delete'),
          ['action' => 'delete', $program->id],
          ['confirm' => __('Are you sure you want to delete # {0}?', $program->id), 'class' => 'btn btn-danger']
      ) ?>
    </div>
    <div class="ml-auto">
      <?= $this->Form->button(__('Save')) ?>
      <?= $this->Html->link(__('Cancel'), ['action' => 'view', $program->id], ['class' => 'btn btn-default']) ?>

    </div>
  </div>

  <?= $this->Form->end() ?>
</div>

