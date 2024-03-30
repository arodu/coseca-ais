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
        echo $this->Form->control('name');
        echo $this->Form->control('abbr');
        echo $this->Form->control('logo', [
            'type' => 'file',
            'accept' => 'image/jpeg,image/png',
            'container' => ['class' => 'custom-file']
        ]);
        ?>
    </div>

    <div class="card-footer d-flex">
        <div class="">
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $area->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $area->id), 'class' => 'btn btn-danger']
            ) ?>
        </div>
        <div class="ml-auto">
            <?= $this->Form->button(__('Save')) ?>
            <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>