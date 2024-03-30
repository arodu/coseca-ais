<?php

/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $tenant
 */
?>
<?php
$this->assign('title', __('Add Tenant'));
$this->assign('backUrl', $redirect ?? null);
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Tenants'), 'url' => ['action' => 'index']],
    ['title' => __('Add')],
]);
?>

<div class="card card-primary card-outline">
    <?= $this->Form->create($tenantFilter, ['valueSources' => ['data', 'query', 'context']]) ?>
    <div class="card-body">
        <?php
        echo $this->Form->control('user_id', ['options' => $appUsers, 'empty' => true]);
        echo $this->Form->control('tenant_id', ['options' => $tenants, 'empty' => true]);
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