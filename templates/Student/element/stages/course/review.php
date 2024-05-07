<?php

/**
 * @var \App\Model\Entity\Student $student
 * @var \App\Model\Entity\StudentStage $studentStage
 */

use App\Utility\FilePrint;

?>
<?php if (empty($student->student_course)) : ?>
    <p><?= __('Sin información a mostrar') ?></p>
    <p><?= $this->App->alertMessage() ?></p>
<?php else : ?>
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

    <?= $this->Button->fileReport([
        'url' => [
            'prefix' => 'Student',
            'controller' => 'Documents',
            'action' => 'format002',
            FilePrint::format002($student),
        ],
        'label' => __('Descargar planilla 002'),
        'target' => '_blank',
        'class' => 'btn-sm',
        'displayCondition' => function () use ($studentStage, $student) {
            $studentStage->course = $student->student_course;
    
            return $this->getIdentity()->can('print', $studentStage);
        },
    ]) ?>
<?php endif; ?>