<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tutor $tutor
 */
?>

<?php
$this->assign('title', __('Tutor'));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Tutors'), 'url' => ['action' => 'index']],
    ['title' => __('View')],
]);
?>

<div class="view card card-primary card-outline">
  <div class="card-header d-sm-flex">
    <h2 class="card-title"><?= h($tutor->name) ?></h2>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($tutor->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Dni') ?></th>
            <td><?= h($tutor->dni) ?></td>
        </tr>
        <tr>
            <th><?= __('Phone') ?></th>
            <td><?= h($tutor->phone) ?></td>
        </tr>
        <tr>
            <th><?= __('Email') ?></th>
            <td><?= h($tutor->email) ?></td>
        </tr>
        <tr>
            <th><?= __('Tenant') ?></th>
            <td><?= $tutor->has('tenant') ? $this->Html->link($tutor->tenant->name, ['controller' => 'Tenants', 'action' => 'view', $tutor->tenant->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($tutor->id) ?></td>
        </tr>
    </table>
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
      <?= $this->Html->link(__('Edit'), ['action' => 'edit', $tutor->id], ['class' => 'btn btn-secondary']) ?>
      <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
    </div>
  </div>
</div>


<div class="related related-adscriptions view card">
  <div class="card-header d-flex">
    <h3 class="card-title"><?= __('Related Adscriptions') ?></h3>
    <div class="ml-auto">
      <?= $this->Html->link(__('New'), ['controller' => 'Adscriptions' , 'action' => 'add'], ['class' => 'btn btn-primary btn-sm']) ?>
      <?= $this->Html->link(__('List '), ['controller' => 'Adscriptions' , 'action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
    </div>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
      <tr>
          <th><?= __('Id') ?></th>
          <th><?= __('Student Id') ?></th>
          <th><?= __('Project Id') ?></th>
          <th><?= __('Lapse Id') ?></th>
          <th><?= __('Tutor Id') ?></th>
          <th><?= __('Created') ?></th>
          <th><?= __('Modified') ?></th>
          <th class="actions"><?= __('Actions') ?></th>
      </tr>
      <?php if (empty($tutor->adscriptions)) { ?>
        <tr>
            <td colspan="8" class="text-muted">
              Adscriptions record not found!
            </td>
        </tr>
      <?php }else{ ?>
        <?php foreach ($tutor->adscriptions as $adscriptions) : ?>
        <tr>
            <td><?= h($adscriptions->id) ?></td>
            <td><?= h($adscriptions->student_id) ?></td>
            <td><?= h($adscriptions->project_id) ?></td>
            <td><?= h($adscriptions->lapse_id) ?></td>
            <td><?= h($adscriptions->tutor_id) ?></td>
            <td><?= h($adscriptions->created) ?></td>
            <td><?= h($adscriptions->modified) ?></td>
            <td class="actions">
              <?= $this->Html->link(__('View'), ['controller' => 'Adscriptions', 'action' => 'view', $adscriptions->id], ['class'=>'btn btn-xs btn-outline-primary']) ?>
              <?= $this->Html->link(__('Edit'), ['controller' => 'Adscriptions', 'action' => 'edit', $adscriptions->id], ['class'=>'btn btn-xs btn-outline-primary']) ?>
              <?= $this->Form->postLink(__('Delete'), ['controller' => 'Adscriptions', 'action' => 'delete', $adscriptions->id], ['class'=>'btn btn-xs btn-outline-danger', 'confirm' => __('Are you sure you want to delete # {0}?', $adscriptions->id)]) ?>
            </td>
        </tr>
        <?php endforeach; ?>
      <?php } ?>
    </table>
  </div>
</div>

