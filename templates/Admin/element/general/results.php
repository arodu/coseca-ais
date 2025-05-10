<?php

/** @var \App\Model\Entity\StudentStage $studentStage */
/** @var \App\Model\Entity\Student $student */
/** @var \App\View\AppView $this */

use App\Model\Field\StageStatus;
use App\Utility\FilePrint;

$status = $studentStage->enum('status');
$color = $status->color();
$icon = $status->icon();

$this->set('studentStage', $studentStage);
$this->extend('/Admin/Common/timeline_item');

$this->start('actions');

echo $this->Button->confirm([
    'label' => __('Cerrar Resultados'),
    'url' => [
        'controller' => 'Results',
        'action' => 'closeStage',
        $studentStage->student_id,
        'prefix' => 'Admin/Stage'
    ],
    'confirm' => __('¿Está seguro de cerrar la etapa de resultados?'),
    'class' => 'btn-sm',
]);
$this->end();

