<?php

/**
 * @var \App\View\AppView $this
 */

use App\Model\Field\StageStatus;

$this->student_id = $studentStage->student_id;
$this->active = null;
$this->extend('/Admin/Common/view_student');

$this->assign('title', __('Estudiante'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Estudiantes'), 'url' => ['controller' => 'Students', 'action' => 'index']],
    ['title' => __('Ver'), 'url' => ['controller' => 'Students', 'action' => 'view', $studentStage->student_id]],
    ['title' => $studentStage->stage],
    ['title' => __('Editar')],
]);
?>

<?= $this->Form->create($studentStage) ?>
<div class="card-body">
    <?php
    echo $this->Form->control('stage', ['readonly' => true]);
    echo $this->Form->control('lapse_id', ['options' => $lapses]);
    echo $this->Form->control('status', ['options' => StageStatus::toListLabel()]);
    ?>
</div>

<div class="card-footer d-flex">
    <div>
        <?= $this->Form->postLink(
            __('Forzar cierre'),
            ['controller' => 'StudentStages', 'action' => 'forcedClose', $studentStage->id],
            [
                'block' => true,
                'class' => 'btn btn-warning',
                'confirm' => __('Esta seguro que desea cerrar esta etapa? Esto podria traer resultados inesperados.')
            ]
        ) ?>
    </div>
    <div class="ml-auto">
        <?= $this->Form->button(__('Guardar')) ?>
        <?= $this->Html->link(__('Cancelar'), ['controller' => 'Students', 'action' => 'view', $studentStage->student_id], ['class' => 'btn btn-default']) ?>
    </div>
</div>
<?= $this->Form->end() ?>