<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tenant $tenant
 */
?>

<?php
$this->assign('title', h($tenant->name));
$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'List Tenants', 'url' => ['action' => 'index']],
    ['title' => 'View'],
]);
?>

<div class="view card card-primary card-outline">
    <div class="card-header d-sm-flex">
        <h2 class="card-title"><?= h($tenant->name) ?></h2>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <tr>
                <th><?= __('Name') ?></th>
                <td><?= h($tenant->name) ?></td>
            </tr>
            <tr>
                <th><?= __('Abbr') ?></th>
                <td><?= h($tenant->abbr) ?></td>
            </tr>
            <tr>
                <th><?= __('Lapso Actual') ?></th>
                <td><?= h($tenant->current_lapse->name) ?></td>
            </tr>
            <tr>
                <th><?= __('Activo') ?></th>
                <td><?= $tenant->active ? __('Si') : __('No'); ?></td>
            </tr>
        </table>
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
            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $tenant->id], ['class' => 'btn btn-secondary']) ?>
            <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="related related-lapses view card">
            <div class="card-body">
                <?= $this->Form->create(null, ['type' => 'GET']) ?>
                <?= $this->Form->control('lapse_id', ['value' => $lapseSelected->id]) ?>
                <?= $this->Html->link(__('Nuevo'), ['controller' => 'Lapses', 'action' => 'add'], ['class' => 'btn btn-primary btn-sm']) ?>
                <?= $this->Form->end() ?>
                <table class="table table-hover mt-3">
                    <tr>
                        <th><?= __('Nombre') ?></th>
                        <td><?= h($lapseSelected->name) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Fecha') ?></th>
                        <td><?= h($lapseSelected->date) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Activo') ?></th>
                        <td><?= $lapseSelected->active ? __('Si') : __('No'); ?></td>
                    </tr>
                </table>
            </div>
            <div class="card-footer d-flex">
                <div>
                    <?= $this->Form->postLink(
                        __('Delete'),
                        ['controller' => 'Lapses', 'action' => 'delete', $tenant->id],
                        ['confirm' => __('Are you sure you want to delete # {0}?', $lapseSelected->id), 'class' => 'btn btn-danger btn-sm']
                    ) ?>
                </div>
                <div class="ml-auto">
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Lapses', 'action' => 'edit', $tenant->id], ['class' => 'btn btn-secondary btn-sm']) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="related related-lapse-dates view card">
            <div class="card-header d-flex">
                <h3 class="card-title"><?= __('Lapso Académico {0}', $lapseSelected->name) ?></h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <tr>
                        <th><?= __('Etapa') ?></th>
                        <th><?= __('Fecha') ?></th>
                        <th><?= __('Estado') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php if (empty($lapseSelected->lapse_dates)) { ?>
                        <tr>
                            <td colspan="3" class="text-muted">
                                Lapse Dates record not found!
                            </td>
                        </tr>
                    <?php } else { ?>
                        <?php foreach ($lapseSelected->lapse_dates as $lapseDates) : ?>
                            <tr>
                                <td><?= h($lapseDates->title) ?></td>
                                <td><?= h($lapseDates->show_dates) ?></td>
                                <td><code><?= $lapseDates->status?->label() ?? __('N/A') ?></code></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('Editar'), ['controller' => 'Lapses', 'action' => 'editDates', $lapseDates->id], ['class' => 'btn btn-xs btn-outline-primary']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
<?= $this->Html->scriptStart(['block' => true]) ?>
    $("select#lapse-id").on('change', function () {
        $(this).closest('form').submit()
    })
<?= $this->Html->scriptEnd() ?>
</script>
