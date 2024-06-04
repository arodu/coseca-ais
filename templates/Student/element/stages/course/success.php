<?php 
/**
 * @var \App\Model\Entity\Student $student
 * @var \App\Model\Entity\StudentStage $studentStage
 */
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
<?php endif; ?>