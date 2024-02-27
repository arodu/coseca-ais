<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Institution[]|\Cake\Collection\CollectionInterface $institutions
 */

use App\Enum\ActionColor;
use CakeLteTools\Utility\FaIcon;

?>
<?php
$this->assign('title', __('Institutions'));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Institutions')],
]);
?>

<div class="card card-success card-outline">
    <div class="card-header d-flex flex-column flex-md-row">
        <h2 class="card-title w-100">
            <span class="d-flex w-100" data-toggle="collapse" href="#collapse-filters">
                <?= FaIcon::get('filter', 'fa-fw mr-2') ?>
                <?= __('Filtros') ?>
                <i class="icon-caret fas fa-caret-up ml-auto fa-fw"></i>
            </span>
        </h2>
    </div>
    <?= $this->Form->create(null, ['type' => 'GET', 'valueSources' => ['query', 'context']]) ?>
    <div class="collapse <?= (($filtered ?? false) ? 'show' : null) ?>" id="collapse-filters">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <?= $this->Form->control('name', ['label' => __('Institución')]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $this->Form->control('contact_person', ['label' => __('Persona de Contacto')]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $this->Form->control('tenant_id', ['label' => __('Programa'), 'empty' => __('--Todos--')]) ?>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex">
            <div>
                <?= $this->Form->button(__('Buscar'), ['class' => ActionColor::SEARCH->btn()]) ?>
            </div>
            <div class="ml-auto">
                <?= $this->Html->link(__('Reset'), ['action' => 'index'], ['class' => ActionColor::CANCEL->btn()]) ?>
            </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>

<div class="card card-primary card-outline">
    <div class="card-header d-flex flex-column flex-md-row">
        <h2 class="card-title">
            <!-- -->
        </h2>
        <div class="d-flex ml-auto gap-3">
            <?= $this->Paginator->limitControl([], null, [
                'label' => false,
                'class' => 'form-control-sm',
                'templates' => ['inputContainer' => '{{content}}']
            ]); ?>
            <?= $this->Button->add([
                'url' => ['action' => 'add', 'prefix' => 'Admin'],
                //'label' => __('Agregar Institución'),
                'class' => 'btn-sm ml-2',
            ]) ?>

            <?= $this->Button->dropdown([
                'class' => 'btn-sm btn-flat',
                'group' => [
                    'class' => 'ml-2',
                ],
                'menu' => [
                    'class' => 'dropdown-menu-right',
                ],
                'items' => [
                    ['label' => __('Eliminados'), 'url' => ['action' => 'index', '?' => ['trash' => 1]]],
                    ['label' => __('Todos'), 'url' => ['action' => 'index']],
                ],
            ]) ?>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('name', __('Institución')) ?></th>
                    <th><?= $this->Paginator->sort('active') ?></th>
                    <th><?= $this->Paginator->sort('contact_person') ?></th>
                    <th><?= $this->Paginator->sort('contact_phone') ?></th>
                    <th><?= $this->Paginator->sort('contact_email') ?></th>
                    <th><?= $this->Paginator->sort('tenant_id', __('Programa')) ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($institutions as $institution) : ?>
                    <tr>
                        <td><?= $this->Html->link(h($institution->name), ['action' => 'view', $institution->id, 'prefix' => 'Admin'], ['class' => '', 'escape' => false]) ?></td>
                        <td><?= $this->App->badge($institution->recordStatus()) ?></td>
                        <td><?= h($institution->contact_person) ?></td>
                        <td><?= h($institution->contact_phone) ?></td>
                        <td><?= h($institution->contact_email) ?></td>
                        <td><?= h($institution->tenant->label) ?></td>
                        <td class="actions">
                            <?= $this->Button->view(['url' => ['action' => 'view', $institution->id, 'prefix' => 'Admin'], 'class' => 'btn-xs']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->

    <div class="card-footer d-flex flex-column flex-md-row">
        <div class="text-muted">
            <?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
        </div>
        <ul class="pagination pagination-sm mb-0 ml-auto">
            <?= $this->Paginator->first('<i class="fas fa-angle-double-left"></i>', ['escape' => false]) ?>
            <?= $this->Paginator->prev('<i class="fas fa-angle-left"></i>', ['escape' => false]) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('<i class="fas fa-angle-right"></i>', ['escape' => false]) ?>
            <?= $this->Paginator->last('<i class="fas fa-angle-double-right"></i>', ['escape' => false]) ?>
        </ul>
    </div>
    <!-- /.card-footer -->
</div>