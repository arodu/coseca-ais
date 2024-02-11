<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Student $student
 * @var \App\Model\Entity\StudentStage $studentStage

 */

use App\Enum\ActionColor;
use CakeLteTools\Utility\FaIcon;

?>

<?php if (empty($student->student_adscriptions)) : ?>
    <p><?= __('El estudiante no tiene proyectos adscritos.') ?></p>
    <p><?= $this->App->alertMessage() ?></p>
<?php else : ?>
    <?= $this->cell('TrackingView::info', ['student_id' => $student->id]) ?>
    <hr>
    <div class="d-flex">
        <div>
            <?= $this->Button->edit([
                'label' => __('Registro de actividades'),
                'url' => ['_name' => 'student:tracking'],
                'actionColor' => ActionColor::EDIT,
                'icon' => FaIcon::get('tasks', 'fa-fw mr-1'),
                'class' => 'btn-sm',
            ]); ?>
        </div>
        <div class="ml-auto">
            <?= $this->cell('TrackingView::actions', ['student_id' => $student->id]) ?>
        </div>
    </div>
<?php endif; ?>