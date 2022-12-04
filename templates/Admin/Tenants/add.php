<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tenant $tenant
 */
?>
<?php
$this->assign('title', __('Nuevo Programa'));
$this->Breadcrumbs->add([
  ['title' => __('Inicio'), 'url' => '/'],
  ['title' => __('Programas'), 'url' => ['controller' => 'Tenants', 'action' => 'index']],
  ['title' => 'Nuevo'],
]);
?>

<div class="card card-primary card-outline">
  <?= $this->Form->create($tenant) ?>
  <div class="card-body">
    <?php
      echo $this->Form->control('name', ['label' => __('Nombre')]);
      echo $this->Form->control('abbr', ['label' => __('ABRV')]);
      echo $this->Form->control('active', ['label' => __('Activo'), 'custom' => true, 'checked' => true]);

      echo $this->Form->control('current_lapse.name', ['label' => __('Lapso Académico')]);
      echo $this->Form->hidden('current_lapse.active', ['value' => true]);
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

