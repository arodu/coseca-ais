<?php 
/**
 * @var \App\Model\Entity\Student $student
 */
?>
<?php if (!empty($student->student_course)) : ?>
    <ul class="list-unstyled">
        <li><strong><?= __('Fecha del Taller: ') ?></strong><?= h($student->student_course->date) ?></li>
        <?php if (!empty($student->student_course->comment)) : ?>
            <li><?= h($student->student_course->comment) ?></li>
        <?php endif ?>
    </ul>
<?php endif; ?>
