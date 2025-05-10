<?php

/** @property \App\Model\Entity\StudentStage $studentStage */

use App\Enum\ActionColor;
use CakeLteTools\Utility\FaIcon;

/** @var \App\View\AppView $this */

$studentStage = $this->get('studentStage');
$status = $studentStage->enum('status');
$color = $status->color();
$icon = $status->icon($color->bg());
$content = trim($this->fetch('content'));
$actions = trim($this->fetch('actions'));
?>

<div>
    <?= $icon->render() ?>
    <div class="timeline-item">
        <span class="time"><i class="far fa-clock"></i> <?= $studentStage->modified ?></span>

        <h3 class="timeline-header"><strong><?= $studentStage->stage_label ?></strong> <small> (<?= $studentStage->status_label ?>)</small></h3>

        <?php if ($content) : ?>
            <div class="timeline-body border-bottom">
                <?= $content ?>
            </div>
        <?php endif; ?>

        <div class="timeline-footer d-flex">
            <?php if ($actions) : ?>
                <div class=""><?= $actions ?></div>
            <?php endif; ?>
            <div class="ml-auto">
                <?= $this->Html->link(
                    FaIcon::get('edit'),
                    ['controller' => 'StudentStages', 'action' => 'edit', $studentStage->id],
                    [
                        'class' => ActionColor::ROOT->text(),
                        'escape' => false
                    ]
                ) ?>
            </div>
        </div>
    </div>
</div>