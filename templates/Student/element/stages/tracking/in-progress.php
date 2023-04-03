<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Student $student
 * @var \App\Model\Entity\StudentStage $studentStage

 */

use App\Enum\ActionColor;
use App\Utility\FaIcon;
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
            <?= $this->Button->edit([
                'label' => __('Registro actividades'),
                'url' => ['controller' => 'TrackingStage', 'action' => 'index'],
                'actionColor' => ActionColor::SUBMIT,
                'icon' => FaIcon::get('tasks', 'fa-fw mr-1'),
            ]); ?>
        </div>
        <div class="ml-auto">
            <?php //@todo move to a policy ?>
            <?php if (($student->total_hours ?? 0) >= Configure::read('coseca.hours-min')) : ?>
                <!-- <?= $this->Button->report([
                            'label' => __('Planilla de actividades'),
                            'url' => ['controller' => 'TrackingStage', 'action' => 'close'],
                            'actionColor' => ActionColor::REPORT,
                            'icon' => FaIcon::get('validate', 'fa-fw mr-1'),
                        ]); ?> -->
            <?php endif ?>
        </div>
    </div>
<?php endif; ?>