<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Adscription $adscription
 */
?>
<?php
$this->assign('title', __('Edit Adscription'));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Adscriptions'), 'url' => ['action' => 'index']],
    ['title' => __('View'), 'url' => ['action' => 'view', $adscription->id]],
    ['title' => __('Edit')],
]);
?>

<div class="card card-primary card-outline">
  <?= $this->Form->create($adscription) ?>
  <div class="card-body">
    <?php
      echo $this->Form->control('student_id', ['options' => $students]);
      echo $this->Form->control('project_id', ['options' => $projects]);
      echo $this->Form->control('lapse_id', ['options' => $lapses]);
      echo $this->Form->control('tutor_id', ['options' => $tutors]);
    ?>
  </div>

  <div class="card-footer d-flex">
    <div class="">
      <?= $this->Form->postLink(
          __('Delete'),
          ['action' => 'delete', $adscription->id],
          ['confirm' => __('Are you sure you want to delete # {0}?', $adscription->id), 'class' => 'btn btn-danger']
      ) ?>
    </div>
    <div class="ml-auto">
      <?= $this->Form->button(__('Save')) ?>
      <?= $this->Html->link(__('Cancel'), ['action' => 'view', $adscription->id], ['class' => 'btn btn-default']) ?>

    </div>
  </div>

  <?= $this->Form->end() ?>
</div>

