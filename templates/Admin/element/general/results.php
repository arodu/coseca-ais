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
if ($studentStage->statusIs([StageStatus::WAITING, StageStatus::IN_PROGRESS])) {
    echo $this->Button->report([
        'label' => __('Planilla 008'),
        'url' => [
            'prefix' => 'Admin',
            'controller' => 'Documents',
            'action' => 'format008',
            $studentStage->student_id,
            FilePrint::format008($student),
        ],
        'class' => 'btn-sm mr-2',
    ]);
}
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

