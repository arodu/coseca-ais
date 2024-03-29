<?php

/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $tenant
 */
?>
<?php
$this->assign('title', __('Edit Tenant'));

$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Tenants'), 'url' => ['action' => 'index']],
    ['title' => __('View'), 'url' => ['action' => 'view', $tenant->id]],
    ['title' => __('Edit')],
]);
?>

<div class="card card-primary card-outline">
    <?= $this->Form->create($tenant, ['valueSources' => ['data', 'query', 'context']]) ?>
    <div class="card-body">
        <?php
        echo $this->Form->control('program_id', ['options' => $programs, 'empty' => true]);
        echo $this->Form->control('location_id', ['options' => $locations, 'empty' => true]);
        echo $this->Form->control('active', ['custom' => true]);
        ?>
    </div>

    <div class="card-footer d-flex">
        <div class="">
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $tenant->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $tenant->id), 'class' => 'btn btn-danger']
            ) ?>
        </div>
        <div class="ml-auto">
            <?= $this->Form->button(__('Save')) ?>
            <?= $this->Html->link(__('Cancel'), ['action' => 'view', $tenant->id], ['class' => 'btn btn-default']) ?>

        </div>
    </div>

    <?= $this->Form->end() ?>
</div>