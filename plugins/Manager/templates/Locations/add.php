<?php

/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $location
 */

use App\Model\Field\LocationType;

?>
<?php
$this->assign('title', __('Add Location'));
$this->assign('backUrl', $redirect ?? $this->Url->build(['action' => 'index']));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Locations'), 'url' => ['action' => 'index']],
    ['title' => __('Add')],
]);
?>

<div class="card card-primary card-outline">
  <?= $this->Form->create($location) ?>
  <div class="card-body">
    <?php
      echo $this->Form->control('name');
      echo $this->Form->control('abbr');
      echo $this->Form->control('type', ['options' => LocationType::toListLabel()]);
    ?>
  </div>

  <div class="card-footer d-flex">
    <div class="ml-auto">
      <?= $this->Form->button(__('Save')) ?>
      <?= $this->Html->link(__('Cancel'), $redirect ?? ['action' => 'index'], ['class' => 'btn btn-default']) ?>

    </div>
  </div>

  <?= $this->Form->end() ?>
</div>

