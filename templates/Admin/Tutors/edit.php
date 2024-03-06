<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tutor $tutor
 */
?>
<?php
$this->assign('title', __('Edit Tutor'));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Tutors'), 'url' => ['action' => 'index']],
    ['title' => __('View'), 'url' => ['action' => 'view', $tutor->id]],
    ['title' => __('Edit')],
]);
?>

<div class="card card-primary card-outline">
  <?= $this->Form->create($tutor) ?>
  <div class="card-body">
    <?php
      echo $this->Form->control('name');
      echo $this->Form->control('dni');
      echo $this->Form->control('phone');
      echo $this->Form->control('email');
      echo $this->Form->control('tenant_id', ['options' => $tenants, 'class' => 'form-control']);
    ?>
  </div>

  <div class="card-footer d-flex">
    <div class="">
      <?= $this->Form->postLink(
          __('Delete'),
          ['action' => 'delete', $tutor->id],
          ['confirm' => __('Are you sure you want to delete # {0}?', $tutor->id), 'class' => 'btn btn-danger']
      ) ?>
    </div>
    <div class="ml-auto">
      <?= $this->Form->button(__('Save')) ?>
      <?= $this->Html->link(__('Cancel'), ['action' => 'view', $tutor->id], ['class' => 'btn btn-default']) ?>

    </div>
  </div>

  <?= $this->Form->end() ?>
</div>

