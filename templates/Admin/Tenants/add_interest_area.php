<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InterestArea $interestArea
 */
?>
<?php
$this->assign('title', __('Add Interest Area'));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Interest Areas'), 'url' => ['action' => 'index']],
    ['title' => __('Add')],
]);
?>

<div class="card card-primary card-outline">
  <?= $this->Form->create($interestArea) ?>
  <div class="card-body">
    <?php
      echo $this->Form->control('program', ['value' => $program->label, 'readonly' => true]);
      echo $this->Form->control('name');
      echo $this->Form->control('description');
      echo $this->Form->control('active', ['custom' => true, 'default' => true]);
    ?>
  </div>

  <div class="card-footer d-flex">
    <div class="ml-auto">
      <?= $this->Form->button(__('Guardar')) ?>
      <?= $this->Html->link(__('Cancelar'), ['action' => 'viewProgram', $program->id], ['class' => 'btn btn-default']) ?>

    </div>
  </div>

  <?= $this->Form->end() ?>
</div>

