<?php

/** @var \App\Model\Entity\StudentStage $studentStage */
/** @var \App\Model\Entity\Student $student */
/** @var \App\View\AppView $this */

use App\Enum\ActionColor;
use App\Model\Field\StageStatus;

$status = $studentStage->status_obj;
$color = $status->color();
$icon = $status->icon();

$this->set('studentStage', $studentStage);
$this->extend('/Admin/Common/timeline_item');

$this->start('actions');
echo $this->Html->link(
    __('Editar Registro'),
    ['controller' => 'Register', 'action' => 'edit', $studentStage->student_id, 'prefix' => 'Admin/Stage'],
    ['class' => ActionColor::EDIT->btn('btn-sm')]
);

echo $this->Html->link(
    __('Ver Registro'),
    ['controller' => 'Students', 'action' => 'info', $studentStage->student_id, 'prefix' => 'Admin'],
    ['class' => ActionColor::VIEW->btn('btn-sm ml-2')]
);
$this->end();
