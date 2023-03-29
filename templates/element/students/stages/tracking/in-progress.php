<?php

/**
 * @var \App\Model\Entity\Student $student
 * @var \App\Model\Entity\StudentStage $studentStage
 */

use App\Enum\ActionColor;
use App\Model\Field\StageStatus;

?>

<?php if (empty($student->student_adscriptions)) : ?>
    <p><?= __('El estudiante no tiene proyectos adscritos.') ?></p>
    <p><?= __('Comuniquese con la coordinación de servicio comunitario para mas información.') ?></p>
<?php else : ?>
    <?= $this->element('content/trackingInfo', ['trackingInfo' => $trackingInfo]) ?>
    <hr>
    <?= $this->Html->link(__('Ver Actividades'), ['controller' => 'TrackingStage', 'action' => 'index'], ['class' => ActionColor::VIEW->btn('btn-sm')]) ?>
<?php endif; ?>