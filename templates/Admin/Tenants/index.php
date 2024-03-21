<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tenant[]|\Cake\Collection\CollectionInterface $tenants
 */

use App\Enum\ActionColor;

?>
<?php
$this->assign('title', __('Programas'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Programas')],
]);
?>

<div class="card card-primary card-outline">
    <div class="card-header d-flex flex-column flex-md-row">
        <h2 class="card-title">
            <!-- -->
        </h2>
        <div class="d-flex ml-auto">
            <?= $this->Paginator->limitControl([], null, [
                'label' => false,
                'class' => 'form-control-sm',
                'templates' => ['inputContainer' => '{{content}}']
            ]); ?>
            <?= $this->Html->link(__('Nuevo Programa'), ['action' => 'addProgram'], ['class' => ActionColor::ADD->btn('btn-sm ml-2')]) ?>
            <?= $this->Html->link(__('Nueva Sede'), ['action' => 'add'], ['class' => ActionColor::ADD->btn('btn-sm ml-2')]) ?>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('programs.area', __('Area')) ?></th>
                    <th><?= $this->Paginator->sort('programs.name', __('Programa')) ?></th>
                    <th><?= $this->Paginator->sort('name', __('Sede')) ?></th>
                    <th><?= $this->Paginator->sort('abbr', __('ABRV')) ?></th>
                    <th><?= $this->Paginator->sort('programs.regime', __('Regimen')) ?></th>
                    <th><?= $this->Paginator->sort('current_lapse', __('Lapso Actual')) ?></th>
                    <th><?= $this->Paginator->sort('active', __('Activo')) ?></th>
                    <th class="actions"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tenants as $tenant) : ?>
                    <tr>
                        <td><?= h($tenant->program->area_label) ?></td>
                        <td><?= $this->Html->link($tenant->program->name, ['action' => 'viewProgram', $tenant->program_id], ['class' => '', 'escape' => false]) ?></td>
                        <td><?= $this->Html->link($tenant->location->name, ['action' => 'view', $tenant->id], ['class' => '', 'escape' => false]) ?></td>
                        <td><?= h($tenant->abbr_label) ?></td>
                        <td><?= h($tenant->program->regime_label) ?></td>
                        <td><?= $this->App->lapseLabel($tenant->current_lapse) ?? $this->App->error(__('Programa debe tener al menos un lapso activo')) ?></td>
                        <td><?= $this->App->yn($tenant->active) ?></td>
                        <td class="actions">
                            <?= $this->Button->statistics([
                                'url' => ['controller' => 'Reports', 'action' => 'tenant', $tenant->id],
                                'class' => 'btn-xs'
                            ]) ?>
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
