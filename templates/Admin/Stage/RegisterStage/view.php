<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Student $student
 */
?>

<?php
$this->assign('title', __('Student'));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Students'), 'url' => ['action' => 'index']],
    ['title' => __('View')],
]);
?>

<div class="view card card-primary card-outline">
  <div class="card-header d-sm-flex">
    <h2 class="card-title"><?= h($student->id) ?></h2>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <tr>
            <th><?= __('App User') ?></th>
            <td><?= $student->has('app_user') ? $this->Html->link($student->app_user->username, ['controller' => 'AppUsers', 'action' => 'view', $student->app_user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Tenant') ?></th>
            <td><?= $student->has('tenant') ? $this->Html->link($student->tenant->name, ['controller' => 'Tenants', 'action' => 'view', $student->tenant->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Type') ?></th>
            <td><?= h($student->type) ?></td>
        </tr>
        <tr>
            <th><?= __('Dni') ?></th>
            <td><?= h($student->dni) ?></td>
        </tr>
        <tr>
            <th><?= __('Created By') ?></th>
            <td><?= h($student->created_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified By') ?></th>
            <td><?= h($student->modified_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Last Stage') ?></th>
            <td><?= $student->has('last_stage') ? $this->Html->link($student->last_stage->id, ['controller' => 'StudentStages', 'action' => 'view', $student->last_stage->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Student Data') ?></th>
            <td><?= $student->has('student_data') ? $this->Html->link($student->student_data->id, ['controller' => 'StudentData', 'action' => 'view', $student->student_data->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Student Course') ?></th>
            <td><?= $student->has('student_course') ? $this->Html->link($student->student_course->id, ['controller' => 'StudentCourses', 'action' => 'view', $student->student_course->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($student->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($student->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($student->modified) ?></td>
        </tr>
    </table>
  </div>
  <div class="card-footer d-flex">
    <div class="">
      <?= $this->Form->postLink(
          __('Delete'),
          ['action' => 'delete', $student->id],
          ['confirm' => __('Are you sure you want to delete # {0}?', $student->id), 'class' => 'btn btn-danger']
      ) ?>
    </div>
    <div class="ml-auto">
      <?= $this->Html->link(__('Edit'), ['action' => 'edit', $student->id], ['class' => 'btn btn-secondary']) ?>
      <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
    </div>
  </div>
</div>


<div class="related related-studentStages view card">
  <div class="card-header d-flex">
    <h3 class="card-title"><?= __('Related Student Stages') ?></h3>
    <div class="ml-auto">
      <?= $this->Html->link(__('New'), ['controller' => 'StudentStages' , 'action' => 'add'], ['class' => 'btn btn-primary btn-sm']) ?>
      <?= $this->Html->link(__('List '), ['controller' => 'StudentStages' , 'action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
    </div>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
      <tr>
          <th><?= __('Id') ?></th>
          <th><?= __('Student Id') ?></th>
          <th><?= __('Stage') ?></th>
          <th><?= __('Lapse Id') ?></th>
          <th><?= __('Status') ?></th>
          <th><?= __('Created') ?></th>
          <th><?= __('Created By') ?></th>
          <th><?= __('Modified') ?></th>
          <th><?= __('Modified By') ?></th>
          <th class="actions"><?= __('Actions') ?></th>
      </tr>
      <?php if (empty($student->student_stages)) { ?>
        <tr>
            <td colspan="10" class="text-muted">
              Student Stages record not found!
            </td>
        </tr>
      <?php }else{ ?>
        <?php foreach ($student->student_stages as $studentStages) : ?>
        <tr>
            <td><?= h($studentStages->id) ?></td>
            <td><?= h($studentStages->student_id) ?></td>
            <td><?= h($studentStages->stage) ?></td>
            <td><?= h($studentStages->lapse_id) ?></td>
            <td><?= h($studentStages->status) ?></td>
            <td><?= h($studentStages->created) ?></td>
            <td><?= h($studentStages->created_by) ?></td>
            <td><?= h($studentStages->modified) ?></td>
            <td><?= h($studentStages->modified_by) ?></td>
            <td class="actions">
              <?= $this->Html->link(__('View'), ['controller' => 'StudentStages', 'action' => 'view', $studentStages->id], ['class'=>'btn btn-xs btn-outline-primary']) ?>
              <?= $this->Html->link(__('Edit'), ['controller' => 'StudentStages', 'action' => 'edit', $studentStages->id], ['class'=>'btn btn-xs btn-outline-primary']) ?>
              <?= $this->Form->postLink(__('Delete'), ['controller' => 'StudentStages', 'action' => 'delete', $studentStages->id], ['class'=>'btn btn-xs btn-outline-danger', 'confirm' => __('Are you sure you want to delete # {0}?', $studentStages->id)]) ?>
            </td>
        </tr>
        <?php endforeach; ?>
      <?php } ?>
    </table>
  </div>
</div>

<div class="related related-studentAdscriptions view card">
  <div class="card-header d-flex">
    <h3 class="card-title"><?= __('Related Student Adscriptions') ?></h3>
    <div class="ml-auto">
      <?= $this->Html->link(__('New'), ['controller' => 'StudentAdscriptions' , 'action' => 'add'], ['class' => 'btn btn-primary btn-sm']) ?>
      <?= $this->Html->link(__('List '), ['controller' => 'StudentAdscriptions' , 'action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
    </div>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
      <tr>
          <th><?= __('Id') ?></th>
          <th><?= __('Student Id') ?></th>
          <th><?= __('Institution Project Id') ?></th>
          <th><?= __('Lapse Id') ?></th>
          <th><?= __('Tutor Id') ?></th>
          <th><?= __('Created') ?></th>
          <th><?= __('Modified') ?></th>
          <th class="actions"><?= __('Actions') ?></th>
      </tr>
      <?php if (empty($student->student_adscriptions)) { ?>
        <tr>
            <td colspan="8" class="text-muted">
              Student Adscriptions record not found!
            </td>
        </tr>
      <?php }else{ ?>
        <?php foreach ($student->student_adscriptions as $studentAdscriptions) : ?>
        <tr>
            <td><?= h($studentAdscriptions->id) ?></td>
            <td><?= h($studentAdscriptions->student_id) ?></td>
            <td><?= h($studentAdscriptions->institution_project_id) ?></td>
            <td><?= h($studentAdscriptions->lapse_id) ?></td>
            <td><?= h($studentAdscriptions->tutor_id) ?></td>
            <td><?= h($studentAdscriptions->created) ?></td>
            <td><?= h($studentAdscriptions->modified) ?></td>
            <td class="actions">
              <?= $this->Html->link(__('View'), ['controller' => 'StudentAdscriptions', 'action' => 'view', $studentAdscriptions->id], ['class'=>'btn btn-xs btn-outline-primary']) ?>
              <?= $this->Html->link(__('Edit'), ['controller' => 'StudentAdscriptions', 'action' => 'edit', $studentAdscriptions->id], ['class'=>'btn btn-xs btn-outline-primary']) ?>
              <?= $this->Form->postLink(__('Delete'), ['controller' => 'StudentAdscriptions', 'action' => 'delete', $studentAdscriptions->id], ['class'=>'btn btn-xs btn-outline-danger', 'confirm' => __('Are you sure you want to delete # {0}?', $studentAdscriptions->id)]) ?>
            </td>
        </tr>
        <?php endforeach; ?>
      <?php } ?>
    </table>
  </div>
</div>

