<?php

/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $area
 */
?>

<?php
$this->assign('title', h($area->name));
$this->assign('backUrl', $this->Url->build(['action' => 'index']));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Areas'), 'url' => ['action' => 'index']],
    ['title' => __('View')],
]);
?>

<div class="view card card-primary card-outline">
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


<div class="related related-programs view card">
    <div class="card-header d-flex">
        <h3 class="card-title"><?= __('Programs') ?></h3>
        <div class="ml-auto">
            <?= $this->Html->link(
                __('New Program'),
                [
                    'controller' => 'Programs',
                    'action' => 'add',
                    '?' => ['area_id' => $area->id, 'redirect' => $this->getRequest()->getRequestTarget()]
                ],
                ['class' => 'btn btn-xs btn-primary']
            ) ?>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <tr>
                <th><?= __('Nombre') ?></th>
                <th><?= __('Abbr') ?></th>
                <th><?= __('Regimen') ?></th>
                <th><?= __('Creado') ?></th>
                <th><?= __('Modificado') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php if (empty($area->programs)) { ?>
                <tr>
                    <td colspan="4" class="text-muted">
                        <?= __('Programs not found!') ?>
                    </td>
                </tr>
            <?php } else { ?>
                <?php foreach ($area->programs as $program) : ?>
                    <tr>
                        <td><?= h($program->name) ?></td>
                        <td><?= h($program->abbr) ?></td>
                        <td><?= h($program->regime_label) ?></td>
                        <td><?= h($program->created) ?></td>
                        <td><?= h($program->modified) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(
                                __('Editar'),
                                [
                                    'controller' => 'Programs',
                                    'action' => 'edit',
                                    $program->id,
                                    '?' => ['redirect' => $this->getRequest()->getRequestTarget()]
                                ],
                                [
                                    'class' => 'btn btn-xs btn-outline-primary'
                                ]
                            ) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php } ?>
        </table>
    </div>
</div>