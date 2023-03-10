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
    ['class' => 'btn btn-primary btn-sm']
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
            <tr>
                <th class="narrow"></th>
                <th><?= __('Institución') ?></th>
                <th><?= __('Proyecto') ?></th>
                <th><?= __('Lapso') ?></th>
                <th><?= __('Tutor') ?></th>
                <th><?= __('Estado') ?></th>
            </tr>
            <?php foreach ($student->student_adscriptions as $student_adscriptions) : ?>
                <tr>
                    <td>
                        <?= $this->Html->link(
                            FaIcon::get('edit', 'fa-fw'),
                            ['controller' => 'Adscriptions', 'action' => 'edit', $student_adscriptions->id, 'prefix' => 'Admin/Stage'],
                            ['class' => 'btn btn-link btn-sm text-info', 'escape' => false]
                        ) ?>
                    </td>
                    <td><?= $student_adscriptions->institution_project->institution->name ?></td>
                    <td><?= $student_adscriptions->institution_project->name ?></td>
                    <td><?= $student_adscriptions->lapse->name ?></td>
                    <td><?= $student_adscriptions->tutor->name ?></td>
                    <td><?= $student_adscriptions->lapse->active ? __('Activo') : __('Inactivo') ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
<?php endif; ?>