<?php

/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $user
 */

use App\Model\Field\UserRole;
$currentUser = $this->Identity->get();
?>
<?php
$this->assign('title', __('Add User'));
$this->assign('backUrl', $redirect ?? $this->Url->build(['action' => 'index']));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Users'), 'url' => ['action' => 'index']],
    ['title' => __('Add')],
]);
?>

<div class="card card-primary card-outline">
  <?= $this->Form->create($user) ?>
  <div class="card-body">
    <?php
      echo $this->Form->control('dni');
      echo $this->Form->control('first_name');
      echo $this->Form->control('last_name');
      echo $this->Form->control('email');
      echo $this->Form->control('active', ['custom' => true]);
      echo $this->Form->control('role', ['options' => UserRole::newUserList($currentUser->enum('role')), 'empty' => true]);
    ?>
  </div>

  <div class="card-footer d-flex">
    <div class="ml-auto">
      <?= $this->Form->button(__('Save')) ?>
      <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>

    </div>
  </div>

  <?= $this->Form->end() ?>
</div>

