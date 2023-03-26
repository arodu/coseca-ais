<?php

/** @var \App\Model\Entity\StudentStage $studentStage */
/** @var \App\Model\Entity\Student $student */
/** @var \App\View\AppView $this */

use App\Model\Field\StageStatus;
use App\Utility\FaIcon;

$status = $studentStage->status_obj;
$color = $status->color();
$icon = $status->icon();

$this->set('studentStage', $studentStage);
$this->extend('/Admin/Common/timeline_item');

$this->start('actions');
echo $this->Html->link(
    __('Agregar Proyecto'),
    ['controller' => 'Adscriptions', 'action' => 'add', $student->id, 'prefix' => 'Admin/Stage'],
    ['class' => 'btn btn-info btn-sm']
);

echo $this->Html->link(
    __('Ver Proyectos'),
    ['controller' => 'Students', 'action' => 'adscriptions', $student->id, 'prefix' => 'Admin'],
    ['class' => 'btn btn-default btn-sm ml-2']
);

$this->end();

?>

<?php if (empty($student->student_adscriptions)) : ?>
    <div class="bg-warning p-1">
        <?= __('No hay proyectos adscritos') ?>
    </div>
<?php else : ?>
    <div class="table-responsive">
        <table class="table table-sm table-borderless table-hover m-0">
            <thead>
                <tr>
                    <th><?= __('Institución') ?></th>
                    <th><?= __('Proyecto') ?></th>
                    <th><?= __('Tutor') ?></th>
                    <th><?= __('Lapso') ?></th>
                    <th><?= __('Estado') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($student->student_adscriptions as $student_adscriptions) : ?>
                    <tr>
                        <td><?= $student_adscriptions->institution_project->institution->name ?></td>
                        <td><?= $student_adscriptions->institution_project->name ?></td>
                        <td><?= $student_adscriptions->tutor->name ?></td>
                        <td><?= $student_adscriptions->lapse->name ?></td>
                        <td><?= $this->App->badge($student_adscriptions->status_obj) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
