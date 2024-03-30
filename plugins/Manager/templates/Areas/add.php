<?php

/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $area
 */
?>
<?php
$this->assign('title', __('Add Area'));
$this->assign('backUrl', $redirect ?? $this->Url->build(['action' => 'index']));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Areas'), 'url' => ['action' => 'index']],
    ['title' => __('Add')],
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
        <div class="ml-auto">
            <?= $this->Form->button(__('Save')) ?>
            <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>

        </div>
    </div>

    <?= $this->Form->end() ?>
</div>