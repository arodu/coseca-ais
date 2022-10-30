<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StudentStage $studentStage
 */
?>

<?php
$this->assign('title', __('Student Stage'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'List Student Stages', 'url' => ['action' => 'index']],
    ['title' => 'View'],
]);
?>

<div class="view card card-primary card-outline">
  <div class="card-header d-sm-flex">
    <h2 class="card-title"><?= h($studentStage->id) ?></h2>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <tr>
            <th><?= __('Student') ?></th>
            <td><?= $studentStage->has('student') ? $this->Html->link($studentStage->student->id, ['controller' => 'Students', 'action' => 'view', $studentStage->student->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Stage') ?></th>
            <td><?= h($studentStage->stage) ?></td>
        </tr>
        <tr>
            <th><?= __('Lapse') ?></th>
            <td><?= $studentStage->has('lapse') ? $this->Html->link($studentStage->lapse->name, ['controller' => 'Lapses', 'action' => 'view', $studentStage->lapse->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= h($studentStage->status) ?></td>
        </tr>
        <tr>
            <th><?= __('Created By') ?></th>
            <td><?= h($studentStage->created_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified By') ?></th>
            <td><?= h($studentStage->modified_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($studentStage->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($studentStage->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($studentStage->modified) ?></td>
        </tr>
    </table>
  </div>
  <div class="card-footer d-flex">
    <div class="">
      <?= $this->Form->postLink(
          __('Delete'),
          ['action' => 'delete', $studentStage->id],
          ['confirm' => __('Are you sure you want to delete # {0}?', $studentStage->id), 'class' => 'btn btn-danger']
      ) ?>
    </div>
    <div class="ml-auto">
      <?= $this->Html->link(__('Edit'), ['action' => 'edit', $studentStage->id], ['class' => 'btn btn-secondary']) ?>
      <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
    </div>
  </div>
</div>


