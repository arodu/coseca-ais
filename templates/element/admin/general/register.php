<?php

/** @var \App\Model\Entity\StudentStage $studentStage */

use App\Model\Field\StageStatus;

$status = $studentStage->getStatus();
$color = $status->color();
$icon = $status->icon();
?>

<div>
    <?= $icon->render($color->cssClass('bg', false)) ?>
    <div class="timeline-item">
        <span class="time"><i class="far fa-clock"></i> <?= $studentStage->modified ?></span>

        <h3 class="timeline-header"><strong><?= $studentStage->stage_label ?></strong> <small> (<?= $studentStage->status_label ?>)</small></h3>

        <div class="timeline-body">
            <!-- Etsy  edmodo ifttt zimbra. Babblely odeo kaboodle
            quora plaxo ideeli hulu weebly balihoo... -->
        </div>
        <div class="timeline-footer d-flex">
            <div>
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
            <!-- <a href="#" class="btn btn-primary btn-sm">Read more</a>
            <a href="#" class="btn btn-danger btn-sm">Delete</a> -->
        </div>
    </div>
</div>
