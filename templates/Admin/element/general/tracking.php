<?php

/** @var \App\Model\Entity\StudentStage $studentStage */
/** @var \App\Model\Entity\Student $student */
/** @var \App\View\AppView $this */

use App\Enum\ActionColor;

$status = $studentStage->getStatus();
$color = $status->color();
$icon = $status->icon();

$this->set('studentStage', $studentStage);
$this->extend('/Admin/Common/timeline_item');

$this->start('actions');
echo $this->Button->confirm([
    'label' => __('Cerrar Seguimiento'),
    'url' => [
        'controller' => 'Tracking',
        'action' => 'closeStage',
        $studentStage->student_id,
        'prefix' => 'Admin/Stage'
    ],
    'confirm' => __('¿Está seguro de cerrar la etapa de seguimiento?'),
    'class' => 'btn-sm',
]);

echo $this->Html->link(
    __('Ver Seguimiento'),
    ['controller' => 'Students', 'action' => 'tracking', $studentStage->student_id, 'prefix' => 'Admin'],
    ['class' => ActionColor::VIEW->btn('btn-sm ml-2')]
);
$this->end();

echo $this->cell('TrackingView::info', ['student_id' => $studentStage->student_id]);
