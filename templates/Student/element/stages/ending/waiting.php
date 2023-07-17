<?php

/**
 * @var \App\Model\Entity\Student $student
 * @var \App\Model\Entity\StudentStage $studentStage
 */

use App\Enum\ActionColor;

?>

<?= $this->Button->report([
    'url' => [
        'prefix' => 'Student',
        'controller' => 'Documents',
        'action' => 'format009',
    ],
    'label' => __('Planilla 009'),
    'actionColor' => ActionColor::EDIT,
    'target' => '_blank',
]) ?>