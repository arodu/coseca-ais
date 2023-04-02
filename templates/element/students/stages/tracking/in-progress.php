<?php

/**
 * @var \App\Model\Entity\Student $student
 * @var \App\Model\Entity\StudentStage $studentStage
 */

use App\Enum\ActionColor;
use App\Model\Field\StageStatus;
use Cake\Core\Configure;

?>

<?php if (empty($student->student_adscriptions)) : ?>
    <p><?= __('El estudiante no tiene proyectos adscritos.') ?></p>
    <p><?= $this->App->alertMessage() ?></p>
<?php else : ?>
    <?= $this->element('content/trackingInfo', ['trackingInfo' => $trackingInfo]) ?>
    <hr>
    <div class="d-flex">
        <div>
            <?= $this->Html->link(__('Ver actividades'), ['controller' => 'TrackingStage', 'action' => 'index'], ['class' => ActionColor::VIEW->btn('btn-sm')]) ?>
        </div>
        <div class="ml-auto">
            <?php if (($student->total_hours ?? 0) >= Configure::read('coseca.hours-min')) : ?>
                <?= $this->Html->link(__('Cerrar actividades'), ['controller' => 'TrackingStage', 'action' => 'close'], ['class' => ActionColor::SPECIAL->btn('btn-sm')]) ?>
            <?php endif ?>
        </div>
    </div>
<?php endif; ?>