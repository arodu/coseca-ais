<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Lapse $lapse
 */

$lapse = $lapse_date->lapse;
$tenant = $lapse_date->lapse->tenant;

?>
<?php
$this->assign('title', __('Edit Lapse'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Programas'), 'url' => ['controller' => 'Tenants', 'action' => 'index']],
    ['title' => __('Ver'), 'url' => ['controller' => 'Tenants', 'action' => 'view', $tenant->id, '?' => ['lapse_id' => $lapse->id]]],
    ['title' => __('Fecha Lapso')],
]);
?>

<div class="card card-primary card-outline">
    <?= $this->Form->create($lapse_date) ?>
    <div class="card-body">

        <div class="row">
            <div class="col">
                <?= $this->Form->control('program', [
                    'label' => __('Programa'),
                    'value' => $lapse_date->lapse->tenant_name,
                    'readonly' => true
                ]) ?>
            </div>
            <div class="col">
                <?= $this->Form->control('etapa', [
                    'label' => __('Etapa'),
                    'value' => $lapse_date->title,
                    'readonly' => true
                ]) ?>
            </div>
        </div>
        <?= $this->Form->control('is_single_date', ['label' => __('Fecha Única'), 'custom' => true, 'id' => 'is_single_date']) ?>

        <div class="row">
            <div class="col-6">
                <?= $this->Form->control('start_date', ['label' => 'Fecha Inicio', 'required' => true]) ?>
            </div>
            <div class="col-6" id="input-end-date">
                <?= $this->Form->control('end_date', ['label' => 'Fecha Fin', 'required' => true]) ?>
            </div>
        </div>
    </div>

    <div class="card-footer d-flex">
        <div class="ml-auto">
            <?= $this->Form->button(__('Guardar')) ?>
            <?= $this->Html->link(__('Cancelar'), ['controller' => 'Tenants', 'action' => 'view', $tenant->id, '?' => ['lapse_id' => $lapse->id]], ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <?= $this->Form->end() ?>
</div>

<script>
    <?= $this->Html->scriptStart(['block' => true]) ?>
    function checkSingleDate() {
        if ($('#is_single_date').is(':checked')) {
            $('#input-end-date input').prop('disabled', true)
        } else {
            $('#input-end-date input').prop('disabled', false)
        }
    }

    $('#is_single_date').on('click', checkSingleDate)

    checkSingleDate()
    <?= $this->Html->scriptEnd() ?>
</script>
