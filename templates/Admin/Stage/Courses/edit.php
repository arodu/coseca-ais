<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StudentCourse $studentCourse
 */
?>
<?php
$this->assign('title', __('Edit Student Course'));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Student Courses'), 'url' => ['action' => 'index']],
    ['title' => __('View'), 'url' => ['action' => 'view', $studentCourse->id]],
    ['title' => __('Edit')],
]);
?>

<div class="card card-primary card-outline">
  <?= $this->Form->create($studentCourse) ?>
  <div class="card-body">
    <?php
      echo $this->Form->control('student_id', ['options' => $students]);
      echo $this->Form->control('date');
      echo $this->Form->control('comment');
    ?>
  </div>

  <div class="card-footer d-flex">
    <div class="">
      <?= $this->Form->postLink(
          __('Delete'),
          ['action' => 'delete', $studentCourse->id],
          ['confirm' => __('Are you sure you want to delete # {0}?', $studentCourse->id), 'class' => 'btn btn-danger']
      ) ?>
    </div>
    <div class="ml-auto">
      <?= $this->Form->button(__('Save')) ?>
      <?= $this->Html->link(__('Cancel'), ['action' => 'view', $studentCourse->id], ['class' => 'btn btn-default']) ?>

    </div>
  </div>

  <?= $this->Form->end() ?>
</div>

