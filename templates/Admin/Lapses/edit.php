<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Lapse $lapse
 */
?>
<?php
$this->assign('title', __('Edit Lapse'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'List Lapses', 'url' => ['action' => 'index']],
    ['title' => 'View', 'url' => ['action' => 'view', $lapse->id]],
    ['title' => 'Edit'],
]);
$this->MenuLte->activeItem('lapses');
?>

<div class="card card-primary card-outline">
  <?= $this->Form->create($lapse) ?>
  <div class="card-body">
    <?php
      echo $this->Form->control('name');
      echo $this->Form->control('active', ['custom' => true]);
      echo $this->Form->control('date');
    ?>
  </div>

  <div class="card-footer d-flex">
    <div class="">
      <?= $this->Form->postLink(
          __('Delete'),
          ['action' => 'delete', $lapse->id],
          ['confirm' => __('Are you sure you want to delete # {0}?', $lapse->id), 'class' => 'btn btn-danger']
      ) ?>
    </div>
    <div class="ml-auto">
      <?= $this->Form->button(__('Save')) ?>
      <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
    </div>
  </div>

  <?= $this->Form->end() ?>
</div>

