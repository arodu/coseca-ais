<?php

/** @var \App\Model\Entity\StudentStage $studentStage */
/** @var \App\Model\Entity\Student $student */

use App\Enum\FaIcon;
use App\Model\Field\StageStatus;

$status = $studentStage->status_obj;
$color = $status->color();
$icon = $status->icon();
?>

<div>
    <?= $icon->render($color->cssClass('bg', false)) ?>
    <div class="timeline-item">
        <span class="time"><i class="far fa-clock"></i> <?= $studentStage->modified ?></span>

        <h3 class="timeline-header"><strong><?= $studentStage->stage_label ?></strong> <small> (<?= $studentStage->status_label ?>)</small></h3>

        <div class="timeline-body p-0">
            <?php if (empty($student->student_adscriptions)) : ?>
                <div class="alert alert-warning m-4">
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
                            <td><?= $student_adscriptions->project->institution->name ?></td>
                            <td><?= $student_adscriptions->project->name ?></td>
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
        </div>
        <div class="timeline-footer d-flex border-top">
            <div>
                <?php
                if (!in_array($status, [StageStatus::PENDING])) :
                    echo $this->Html->link(
                        __('Agregar a Proyecto'),
                        ['controller' => 'StudentAdscriptions', 'action' => 'add', $studentStage->id],
                        ['class' => 'btn btn-primary btn-sm']
                    );
                endif;
                ?>
            </div>

            <div class="ml-auto">
                <?= $this->Html->link(
                    __('Editar'),
                    ['controller' => 'StudentStages', 'action' => 'edit', $studentStage->id],
                    [
                        'class' => 'btn btn-default btn-sm',
                    ]
                ) ?>
            </div>
        </div>
    </div>
</div>