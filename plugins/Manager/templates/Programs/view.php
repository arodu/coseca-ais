<?php

/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $program
 */
?>

<?php
$this->assign('title', __('Program'));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Programs'), 'url' => ['action' => 'index']],
    ['title' => __('View')],
]);
?>

<div class="view card card-primary card-outline">
  <div class="card-header d-sm-flex">
    <h2 class="card-title"><?= h($program->name) ?></h2>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($program->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Regime') ?></th>
            <td><?= h($program->regime) ?></td>
        </tr>
        <tr>
            <th><?= __('Abbr') ?></th>
            <td><?= h($program->abbr) ?></td>
        </tr>
        <tr>
            <th><?= __('Created By') ?></th>
            <td><?= h($program->created_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified By') ?></th>
            <td><?= h($program->modified_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Deleted By') ?></th>
            <td><?= h($program->deleted_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($program->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Area Id') ?></th>
            <td><?= $this->Number->format($program->area_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($program->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($program->modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Deleted') ?></th>
            <td><?= h($program->deleted) ?></td>
        </tr>
    </table>
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
      <?= $this->Html->link(__('Edit'), ['action' => 'edit', $program->id], ['class' => 'btn btn-secondary']) ?>
      <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
    </div>
  </div>
</div>


