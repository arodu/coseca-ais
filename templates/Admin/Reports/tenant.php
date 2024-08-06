<?php

/**
 * @var \App\View\AppView $this
 */
?>
<?php
$label = __('{0} - {1}', $tenant->program->name, $tenant->name);

$this->assign('title', __('{0}: <span class="text-muted">{1}</span>', $label, $lapseSelected->name));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Programas'), 'url' => ['controller' => 'Tenants', 'action' => 'index']],
    ['title' => h($tenant->program->name), 'url' => ['controller' => 'Tenants', 'action' => 'viewProgram', $tenant->program_id]],
    ['title' => h($tenant->name), 'url' => ['controller' => 'Tenants', 'action' => 'view', $tenant->id]],
    ['title' => __('Reportes')],
]);
?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header d-flex">
                <div class="d-flex">
                    <?= $this->Form->create(null, ['type' => 'GET']) ?>
                    <?= $this->Form->control('tab', ['type' => 'hidden', 'value' => $currentTab]) ?>
                    <?= $this->Form->select('lapse_id', $lapses->toArray(), [
                        'onchange' => 'this.form.submit()',
                        'default' => $lapseSelected->id,
                    ]) ?>
                    <?= $this->Form->end() ?>
                </div>
                <div class="ml-auto">
                    <?= $this->cell('ReportTenant::tabs', [
                        'tenant' => $tenant,
                        'currentTab' => $currentTab,
                        'lapseSelected' => $lapseSelected,
                    ]) ?>
                </div>
            </div><!-- /.card-header -->
            <div class="card-body" style="overflow: auto;">
                <?= $this->cell('ReportTenant::' . $currentTab, [
                    'tenant' => $tenant,
                    'lapseSelected' => $lapseSelected,
                ]) ?>
            </div><!-- /.card-body -->
        </div>
    </div>
</div>