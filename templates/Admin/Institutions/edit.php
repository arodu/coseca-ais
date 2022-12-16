<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Institution $institution
 */
?>
<?php
$this->assign('title', __('Edit Institution'));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Institutions'), 'url' => ['action' => 'index', 'prefix' => 'Admin']],
    ['title' => __('View'), 'url' => ['action' => 'view', $institution->id, 'prefix' => 'Admin']],
    ['title' => __('Edit')],
]);
?>

<div class="card card-primary card-outline">
  <?= $this->Form->create($institution) ?>
  <div class="card-body">
    <?php
      echo $this->Form->control('name');
      echo $this->Form->control('active', ['custom' => true]);
      echo $this->Form->control('contact_person');
      echo $this->Form->control('contact_phone');
      echo $this->Form->control('contact_email');
      echo $this->Form->control('tenant_id', ['options' => $tenants]);
    ?>
  </div>

  <div class="card-footer d-flex">
    <div class="">
      <?= $this->Form->postLink(
          __('Delete'),
          ['action' => 'delete', $institution->id, 'prefix' => 'Admin'],
          ['confirm' => __('Are you sure you want to delete # {0}?', $institution->id), 'class' => 'btn btn-danger']
      ) ?>
    </div>
    <div class="ml-auto">
      <?= $this->Form->button(__('Save')) ?>
      <?= $this->Html->link(__('Cancel'), ['action' => 'view', $institution->id, 'prefix' => 'Admin'], ['class' => 'btn btn-default']) ?>

    </div>
  </div>

  <?= $this->Form->end() ?>
</div>

