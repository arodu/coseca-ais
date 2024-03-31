<?php

/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $area
 */
?>
<?php
$this->assign('title', __('Edit Area'));
$this->assign('backUrl', $redirect ?? $this->Url->build(['action' => 'view', $area->id]));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Areas'), 'url' => ['action' => 'index']],
    ['title' => __('View'), 'url' => ['action' => 'view', $area->id]],
    ['title' => __('Edit')],
]);
?>

<div class="card card-primary card-outline">
    <?= $this->Form->create($area, ['type' => 'file']) ?>
    <div class="card-body">
        <?php
        echo $this->Form->control('logo', [
            'type' => 'file',
            'accept' => 'image/jpeg,image/png',
            'container' => ['class' => 'custom-file'],
            'required' => false,
        ]);
        ?>
    </div>

    <div class="card-footer d-flex">
        <div class="">
        </div>
        <div class="ml-auto">
            <?= $this->Form->button(__('Save')) ?>
            <?= $this->Html->link(__('Cancel'), $redirect ?? ['action' => 'view', $area->id], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>