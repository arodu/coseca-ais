<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tenant $tenant
 */

use App\Enum\ActionColor;
use App\Enum\Active;
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
                        ['controller' => 'Tenants', 'action' => 'viewProgram', $tenant->program_id]
                    ) ?></td>
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
        <div>
            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $tenant->id], ['class' => ActionColor::EDIT->btn()]) ?>
        </div>
        <div class="ml-auto">
            <?= $this->Html->link(__('Volver'), ['action' => 'index'], ['class' => ActionColor::BACK->btn()]) ?>
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
                <div class="card-header d-flex">
                    <h3 class="card-title"><?= __('Lapsos') ?></h3>
                    <div class="ml-auto">
                        <?= $this->Html->link(__('Nuevo Lapso'), ['controller' => 'Lapses', 'action' => 'add', $tenant->id], ['class' => ActionColor::ADD->btn('btn-sm')]) ?>
                    </div>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-4">
                            <?= __('Lapso') ?>
                        </dt>
                        <dd class="col-8">
                            <?= $this->Form->create(null, ['type' => 'GET']) ?>
                            <?= $this->Form->control('lapse_id', ['label' => false, 'value' => $lapseSelected->id]) ?>
                            <?= $this->Form->end() ?>
                        </dd>
                        <dt class="col-4">
                            <?= __('Estado') ?>
                        </dt>
                        <dd class="col-8">
                            <?= $this->App->badge($lapseSelected->getActive()) ?>
                        </dd>
                    </dl>
                </div>
                <div class="card-footer d-flex">
                    <div>
                        <?= $this->Html->link(__('Editar'), ['controller' => 'Lapses', 'action' => 'edit', $lapseSelected->id], ['class' => ActionColor::EDIT->btn()]) ?>

                        <?php
                        if ($lapseSelected->getActive()->is(Active::FALSE)) :
                            echo $this->ModalForm->link(
                                __('Activar'),
                                [
                                    'controller' => 'Lapses',
                                    'action' => 'changeActive',
                                    $lapseSelected->id,
                                    1,
                                ],
                                [
                                    'class' => ActionColor::ACTIVATE->btn(),
                                    'target' => 'changeActive',
                                    'confirm' => __('¿Está seguro que desea activar este lapso?<br>Al hacerlo de desactivaran el resto de los lapsos de esta sede.'),
                                    'title' => __('Activar lapso académico {0}', $lapseSelected->name),
                                ]
                            );
                        else :
                            echo $this->ModalForm->link(
                                __('Desactivar'),
                                [
                                    'controller' => 'Lapses',
                                    'action' => 'changeActive',
                                    $lapseSelected->id,
                                    0,
                                ],
                                [
                                    'class' => ActionColor::DEACTIVATE->btn(),
                                    'target' => 'changeActive',
                                    'confirm' => __('¿Está seguro que desea desactivar este lapso?'),
                                    'title' => __('Desactivar lapso académico {0}', $lapseSelected->name),
                                ]
                            );
                        endif;
                        ?>

                    </div>
                    <div class="ml-auto">
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
                        <?= $this->App->badge($lapseSelected->getActive()) ?>
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

<?= $this->ModalForm->modal('changeActive', [
    'element' => \ModalForm\ModalFormPlugin::FORM_CHECKBOX,
    'content' => [
        'title' => true,
        'buttonOk'  => __('Si'),
        'buttonCancel'  => __('No'),
    ]
]) ?>