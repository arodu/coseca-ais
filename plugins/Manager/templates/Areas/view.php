<?php

/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $area
 */
?>

<?php
$this->assign('title', __('Area'));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Areas'), 'url' => ['action' => 'index']],
    ['title' => __('View')],
]);
?>

<div class="view card card-primary card-outline">
    <div class="card-header d-sm-flex">
        <h2 class="card-title"><?= h($area->name) ?></h2>
    </div>
    <div class="card-body table-responsive">
        <div class="row">
            <div class="col-md-3 text-center">
                <?= $this->Html->image($area->logo, ['class' => 'img-fluid', 'alt' => $area->name]) ?>
            </div>
            <div class="col-md-9">
                <table class="table table-hover text-nowrap">
                    <tr>
                        <th><?= __('Name') ?></th>
                        <td><?= h($area->name) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Abbr') ?></th>
                        <td><?= h($area->abbr) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Created') ?></th>
                        <td><?= h($area->created) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Modified') ?></th>
                        <td><?= h($area->modified) ?></td>
                    </tr>
                </table>
            </div>
        </div>
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
            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $area->id], ['class' => 'btn btn-secondary']) ?>
            <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>