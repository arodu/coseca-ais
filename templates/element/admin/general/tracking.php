<?php

/** @var \App\Model\Entity\StudentStage $studentStage */
/** @var \App\Model\Entity\Student $student */
/** @var \App\View\AppView $this */

use App\Model\Field\StageStatus;

$status = $studentStage->status_obj;
$color = $status->color();
$icon = $status->icon();

$this->set('studentStage', $studentStage);
$this->extend('/Admin/Common/timeline_item');

$this->start('actions');
echo $this->Html->link(
    __('Ver Seguimiento'),
    ['controller' => 'Students', 'action' => 'tracking', $studentStage->student_id, 'prefix' => 'Admin'],
    ['class' => 'btn btn-default btn-sm ml-2']
);
$this->end();

echo $this->element('content/trackingInfo', ['trackingInfo' => $trackingInfo]);
