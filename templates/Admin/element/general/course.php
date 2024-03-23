<?php

/** @var \App\Model\Entity\StudentStage $studentStage */
/** @var \App\Model\Entity\Student $student */
/** @var \App\View\AppView $this */

use App\Enum\ActionColor;
use App\Utility\FilePrint;

$status = $studentStage->enum('status');
$color = $status->color();
$icon = $status->icon();

$this->set('studentStage', $studentStage);
$this->extend('/Admin/Common/timeline_item');

$this->start('actions');


echo $this->Button->edit([
    'label' => __('Editar Taller'),
    'url' => [
        'controller' => 'Courses',
        'action' => 'edit',
        $student->id,
        $student?->student_course?->id,
        'prefix' => 'Admin/Stage'
    ],
    'class' => 'btn-sm mr-2',
]);


echo $this->Button->report([
    'label' => __('Planilla 002'),
    'url' => [
        'controller' => 'Documents',
        'action' => 'format002',
        $studentStage->student_id,
        'prefix' => 'Admin',
        FilePrint::format('planilla002', $student),
    ],
    'class' => 'btn-sm mr-2',
    'displayCondition' => function () use ($studentStage, $student) {
        $studentStage->course = $student->student_course;

        return $this->getIdentity()->can('print', $studentStage);
    },
]);

echo $this->Button->confirm([
    'label' => __('Cerrar Taller'),
    'url' => [
        'controller' => 'Courses',
        'action' => 'closeStage',
        $studentStage->student_id,
        'prefix' => 'Admin/Stage',
    ],
    'confirm' => __("¿Está seguro de cerrar el taller?"),
    'class' => 'btn-sm mr-2',
    'actionColor' => ActionColor::SUBMIT,
    'displayCondition' => function () use ($studentStage) {
        return $this->getIdentity()->can('close', $studentStage);
    },
]);


$this->end();
?>

<?php if (!empty($student->student_course)) : ?>
    <ul class="list-unstyled">
        <li>
            <?php if ($student->student_course->exonerated) : ?>
                <strong><?= __('Exonerado: ') ?></strong><?= h($student->student_course->date) ?>
            <?php else : ?>
                <strong><?= __('Realizado: ') ?></strong><?= h($student->student_course->date) ?>
            <?php endif; ?>
        </li>
        <?php if (!empty($student->student_course->comment)) : ?>
            <li><?= h($student->student_course->comment) ?></li>
        <?php endif ?>
    </ul>
<?php endif; ?>