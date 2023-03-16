<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tenant $tenant
 */

use App\Utility\FaIcon;

?>

<?php
$this->assign('title', h($tenant->label));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Programas'), 'url' => ['controller' => 'Tenants', 'action' => 'index']],
    ['title' => h($tenant->program->name), 'url' => ['controller' => 'Tenants', 'action' => 'viewProgram', $tenant->program_id]],
    ['title' => h($tenant->name)],
]);
?>

<div class="view card card-primary card-outline">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <tr>
                <th><?= __('Area') ?></th>
                <td><?= h($tenant->program->area_label) ?></td>
            </tr>
            <tr>
                <th><?= __('Programa') ?></th>
                <td><?= $this->Html->link(
                    h($tenant->program->name),
                    ['controller' => 'Tenants', 'action' => 'viewProgram', $tenant->program_id]) ?></td>
            </tr>
            <tr>
                <th><?= __('Sede') ?></th>
                <td><?= h($tenant->name) ?></td>
            </tr>
            <tr>
                <th><?= __('ABVR') ?></th>
                <td><?= h($tenant->abbr_label) ?></td>
            </tr>
            <tr>
                <th><?= __('Lapso Actual') ?></th>
                <td><?= $tenant?->current_lapse->name ?? $this->App->error(__('Programa debe tener al menos un lapso activo')) ?></td>
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
                __('Eliminar'),
                ['action' => 'delete', $tenant->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $tenant->id), 'class' => 'btn btn-danger']
            ) ?>
        </div>
        <div class="ml-auto">
            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $tenant->id], ['class' => 'btn btn-secondary']) ?>
            <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>

<div class="row">
    <?php if (empty($lapseSelected)) : ?>
        <div class="col">
            <div class="alert alert-danger ">
                <?= FaIcon::get('error', 'fa-fw mr-1') ?>
                <?= __('No existe un lapso academico seleccionado.') ?>
                <?= $this->Html->link(__('Crear nuevo lapso académico.'), ['controller' => 'Lapses', 'action' => 'add', $tenant->id], ['class' => '']) ?>
            </div>
        </div>
    <?php else : ?>
        <div class="col-sm-4">
            <div class="related related-lapses view card">
                <div class="card-body">
                    <?= $this->Form->create(null, ['type' => 'GET']) ?>
                    <?= $this->Form->control('lapse_id', ['label' => __('Lapso Académico'), 'value' => $lapseSelected->id]) ?>
                    <?= $this->Html->link(__('Nuevo'), ['controller' => 'Lapses', 'action' => 'add', $tenant->id], ['class' => 'btn btn-primary btn-sm']) ?>
                    <?= $this->Form->end() ?>
                    <table class="table table-hover mt-3">
                        <tr>
                            <th><?= __('Nombre') ?></th>
                            <td><?= h($lapseSelected->name) ?></td>
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
                            __('Eliminar'),
                            ['controller' => 'Lapses', 'action' => 'delete', $lapseSelected->id],
                            ['confirm' => __('Are you sure you want to delete # {0}?', $lapseSelected->id), 'class' => 'btn btn-danger btn-sm']
                        ) ?>
                    </div>
                    <div class="ml-auto">
                        <?= $this->Html->link(__('Editar'), ['controller' => 'Lapses', 'action' => 'edit', $lapseSelected->id], ['class' => 'btn btn-secondary btn-sm']) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="related related-lapse-dates view card">
                <div class="card-header d-flex">
                    <h3 class="card-title">
                        <?= __('Lapso Académico {0}', $this->App->lapseLabel($lapseSelected)) ?>
                    </h3>
                    <div class="ml-auto">
                        <span class="<?= $lapseSelected->getActive()->color()->cssClass('badge') ?>"><?= $lapseSelected->label_active ?></span>
                    </div>
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
    <?php endif; ?>
</div>

<script>
    <?= $this->Html->scriptStart(['block' => true]) ?>
    $("select#lapse-id").on('change', function() {
        $(this).closest('form').submit()
    })
    <?= $this->Html->scriptEnd() ?>
</script>