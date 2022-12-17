<?php

/** @var \App\Model\Entity\StudentStage $studentStage */
/** @var \App\Model\Entity\Student $student */
/** @var \App\View\AppView $this */

use App\Enum\FaIcon;
use App\Model\Field\StageStatus;

$status = $studentStage->status_obj;
$color = $status->color();
$icon = $status->icon();

$this->set('studentStage', $studentStage);
$this->extend('/Admin/Common/timeline_item');

$this->start('actions');
echo $this->Html->link(
    __('Agregar Proyecto'),
    ['controller' => 'Adscriptions', 'action' => 'add', $student->id, 'prefix' => 'Admin/Stage'],
    ['class' => 'btn btn-primary btn-sm']
);

$this->end();

?>

<?php if (empty($student->student_adscriptions)) : ?>
    <div class="bg-warning p-1">
        <?= __('No hay proyectos adscritos') ?>
    </div>
<?php else : ?>
    <table class="table">
        <tr>
            <th><?= __('Institución') ?></th>
            <th><?= __('Proyecto') ?></th>
            <th><?= __('Lapso') ?></th>
            <th><?= __('Tutor') ?></th>
            <th class="narrow"></th>
        </tr>
        <?php foreach ($student->student_adscriptions as $student_adscriptions) : ?>
            <tr>
                <td><?= $student_adscriptions->institution_project->institution->name ?></td>
                <td><?= $student_adscriptions->institution_project->name ?></td>
                <td><?= $student_adscriptions->lapse->name ?></td>
                <td><?= $student_adscriptions->tutor->name ?></td>
                <td>
                    <?= $this->Html->link(
                        FaIcon::EDIT->render(),
                        ['controller' => 'StudentAdscriptions', 'action' => 'edit', $student_adscriptions->id],
                        ['class' => 'btn btn-link btn-sm', 'escape' => false]
                    ) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

