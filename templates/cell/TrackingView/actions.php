<?php

/**
 * @var \App\View\AppView $this
 */

use App\Enum\ActionColor;
?>

<?= $this->Button->report([
    'label' => __('Planilla 007'),
    'url' => [
        'controller' => 'Documents',
        'action' => 'format007',
        $trackingStage->student_id,
        'prefix' => $this->getPrefix(),
        'format007.pdf',
    ],
    'class' => 'btn-sm',
    'displayCondition' => function () use ($trackingStage) {
        return $this->getIdentity()->can('print', $trackingStage);
    },
]) ?>

<?= $this->Button->confirm([
    'label' => __('Cerrar Seguimiento'),
    'url' => [
        'controller' => 'Tracking',
        'action' => 'closeStage',
        $trackingStage->student_id,
        'prefix' => $this->getPrefix(['else' => 'Admin/Stage']),
    ],
    'confirm' => __("¿Está seguro de cerrar la etapa de seguimiento?\nUna vez cerrada, no podrá seguir agregando actividades"),
    'class' => 'btn-sm',
    'actionColor' => ActionColor::SUBMIT,
    'displayCondition' => function () use ($trackingStage) {
        return $this->getIdentity()->can('close', $trackingStage);
    },
]) ?>