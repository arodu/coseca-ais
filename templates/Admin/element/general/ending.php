<?php

/** @var \App\Model\Entity\StudentStage $studentStage */
/** @var \App\Model\Entity\Student $student */
/** @var \App\View\AppView $this */

use App\Model\Field\StageStatus;

$status = $studentStage->getStatus();
$color = $status->color();
$icon = $status->icon();

$this->set('studentStage', $studentStage);
$this->extend('/Admin/Common/timeline_item');

$this->start('actions');
echo $this->Button->confirm([
    'label' => __('Cerrar Conclusiones'),
    'url' => [
        'controller' => 'Endings',
        'action' => 'closeStage',
        $studentStage->student_id,
        'prefix' => 'Admin/Stage'
    ],
    'confirm' => __('¿Está seguro de cerrar la etapa de conclusiones?'),
    'class' => 'btn-sm',
]);

if ($studentStage->statusIs([StageStatus::WAITING, StageStatus::SUCCESS])) {
    echo $this->Button->report([
        'label' => __('Planilla 009'),
        'url' => [
            'prefix' => 'Admin',
            'controller' => 'Documents',
            'action' => 'format009',
            $studentStage->student_id,
            'format009.pdf',
        ],
        'class' => 'btn-sm ml-2',
    ]);
}

$this->end();

// ending
