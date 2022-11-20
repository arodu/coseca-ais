<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Lapse $lapse
 */
?>

<?php
$this->assign('title', __('Lapse'));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'List Lapses', 'url' => ['action' => 'index']],
    ['title' => 'View'],
]);
?>

<div class="view card card-primary card-outline">
  <div class="card-header d-sm-flex">
    <h2 class="card-title"><?= h($lapse->name) ?></h2>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($lapse->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($lapse->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Date') ?></th>
            <td><?= h($lapse->date) ?></td>
        </tr>
        <tr>
            <th><?= __('Active') ?></th>
            <td><?= $lapse->active ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
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
      <?= $this->Html->link(__('Edit'), ['action' => 'edit', $lapse->id], ['class' => 'btn btn-secondary']) ?>
      <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
    </div>
  </div>
</div>


<div class="related related-studentStages view card">
  <div class="card-header d-sm-flex">
    <h3 class="card-title"><?= __('Related Student Stages') ?></h3>
    <div class="card-toolbox">
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
      <?php if (empty($lapse->student_stages)) { ?>
        <tr>
            <td colspan="10" class="text-muted">
              Student Stages record not found!
            </td>
        </tr>
      <?php }else{ ?>
        <?php foreach ($lapse->student_stages as $studentStages) : ?>
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

