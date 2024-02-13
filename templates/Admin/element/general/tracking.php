<?php

/** @var \App\Model\Entity\StudentStage $studentStage */
/** @var \App\Model\Entity\Student $student */
/** @var \App\View\AppView $this */

use App\Enum\ActionColor;
use App\Utility\FilePrint;

$studentStage->student = $student;
$status = $studentStage->getStatus();
$color = $status->color();
$icon = $status->icon();

$this->set('studentStage', $studentStage);
$this->extend('/Admin/Common/timeline_item');

$this->start('actions');

echo $this->Html->link(
    __('Ver Seguimiento'),
    ['controller' => 'Students', 'action' => 'tracking', $studentStage->student_id, 'prefix' => 'Admin'],
    ['class' => ActionColor::VIEW->btn('btn-sm mr-2')]
);

echo $this->Button->report([
    'label' => __('Planilla 007'),
    'url' => [
        'controller' => 'Documents',
        'action' => 'format007',
        $studentStage->student_id,
        'prefix' => 'Admin',
        FilePrint::format007($student),
    ],
    'class' => 'btn-sm mr-2',
    'displayCondition' => function () use ($studentStage) {
        return $this->getIdentity()->can('print', $studentStage);
    },
]);

echo $this->Button->confirm([
    'label' => __('Cerrar Seguimiento'),
    'url' => [
        'controller' => 'Tracking',
        'action' => 'closeStage',
        $studentStage->student_id,
        'prefix' => 'Admin/Stage',
    ],
    'confirm' => __("¿Está seguro de cerrar la etapa de seguimiento?\nUna vez cerrada, no podrá seguir agregando actividades"),
    'class' => 'btn-sm mr-2',
    'actionColor' => ActionColor::SUBMIT,
    'displayCondition' => function () use ($studentStage) {
        return $this->getIdentity()->can('close', $studentStage);
    },
]);

echo $this->Button->confirm([
    'label' => __('Validar Seguimiento'),
    'url' => [
        'controller' => 'Tracking',
        'action' => 'validateStage',
        $studentStage->student_id,
        'prefix' => 'Admin/Stage'
    ],
    'confirm' => __('¿Está seguro de cerrar la etapa de seguimiento?'),
    'class' => 'btn-sm mr-2',
    'displayCondition' => function () use ($studentStage) {
        return $this->getIdentity()->can('validate', $studentStage);
    },
]);

$this->end();

echo $this->cell('TrackingView::info', ['student_id' => $studentStage->student_id]);
