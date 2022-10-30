<?php

use App\Model\Field\Stages;

/**
 * @var \App\Model\Entity\StudentStage $studentStage
 */

$this->MenuLte->activeItem('home');
$this->assign('title', __('Stages'));
$this->Breadcrumbs->add([
    ['title' => 'Home'],
]);
?>

<div class="row">
    <div id="accordion" class="col-sm-8 offset-sm-2">
        <?php foreach ($stages as $stageKey => $baseStage) : ?>
            <?php $studentStage = $studentStages[$stageKey] ?? null ?>
            <div class="card <?= 'card-' . $this->App->statusColor($studentStage->status ?? null) ?>">
                <div class="card-header">
                    <h4 class="card-title w-100">
                        <a class="d-block w-100" data-toggle="collapse" href="<?= '#collapse-' . $stageKey ?>">
                            <i class="<?= $this->App->statusIcon($studentStage->status ?? null) ?> fa-fw"></i>
                            <?= $baseStage[Stages::DATA_LABEL] ?>
                        </a>
                    </h4>
                </div>
                <?php if ($studentStage->status ?? false) : ?>
                    <div id="<?= 'collapse-' . $stageKey ?>" class="collapse <?= $this->App->statusShow($studentStage->status) ?>" data-parent="#accordion">
                        <div class="card-body">
                            <?php
                            $element = 'stages/' . $stageKey . '/' . $studentStage->status;
                            if (!$this->elementExists($element)) {
                                $element = 'stages/default/' . $studentStage->status;
                            }
                            echo $this->element($element, ['stageInstance' => $studentStage->getStageInstance()]);
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
