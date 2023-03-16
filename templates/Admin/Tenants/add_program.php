<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Program $program
 */

use App\Model\Field\ProgramArea;
use App\Model\Field\ProgramRegime;

?>
<?php
$this->assign('title', __('Nuevo Programa'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Programas'), 'url' => ['action' => 'index']],
    ['title' => __('Nuevo Programa')],
]);
?>

<div class="card card-primary card-outline">
  <?= $this->Form->create($program) ?>
  <div class="card-body">
    <?php
      echo $this->Form->control('name');
      echo $this->Form->control('abbr');
      echo $this->Form->control('area', ['options' => ProgramArea::toListLabel(), 'empty' => true]);
      echo $this->Form->control('regime', ['options' => ProgramRegime::toListLabel(), 'empty' => true]);
    ?>
  </div>

  <div class="card-footer d-flex">
    <div class="ml-auto">
      <?= $this->Form->button(__('Guardar')) ?>
      <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>

    </div>
  </div>

  <?= $this->Form->end() ?>
</div>

