<?php

/** @var \App\Model\Entity\StudentStage $studentStage */
/** @var \App\Model\Entity\Student $student */
/** @var \App\View\AppView $this */

use App\Enum\ActionColor;
use App\Model\Field\StageStatus;

$status = $studentStage->status_obj;
$color = $status->color();
$icon = $status->icon();

$this->set('studentStage', $studentStage);
$this->extend('/Admin/Common/timeline_item');

$this->start('actions');
if (empty($student->student_course)) {
    echo $this->Html->link(
        __('Registrar Taller'),
        ['controller' => 'Courses', 'action' => 'add', $student->id, 'prefix' => 'Admin/Stage'],
        ['class' => ActionColor::ADD->btn('btn-sm')]
    );
} else {
    echo $this->Html->link(
        __('Editar Taller'),
        ['controller' => 'Courses', 'action' => 'edit', $student->student_course->id, 'prefix' => 'Admin/Stage'],
        ['class' => ActionColor::EDIT->btn('btn-sm')]
    );
}
$this->end();

?>

<?php if (!empty($student->student_course)) : ?>
    <ul class="list-unstyled">
        <li><strong><?= __('Realizado: ') ?></strong><?= h($student->student_course->date) ?></li>
        <?php if (!empty($student->student_course->comment)) : ?>
            <li><?= h($student->student_course->comment) ?></li>
        <?php endif ?>
    </ul>
<?php endif; ?>