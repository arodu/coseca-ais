<?php

/**
 * @var \App\Model\Entity\StudentStage $studentStage
 */

use App\Model\Field\StageStatus;
use Cake\Core\Configure;

$statusActive = [
    StageStatus::IN_PROGRESS,
    StageStatus::WAITING,
    StageStatus::REVIEW,
];

$this->assign('title', __('Servicio Comunitario'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio')],
]);
?>

<div class="row">
    <div id="stage-list" class="col-sm-12 col-md-8 offset-md-2">
        <?php foreach ($listStages as $itemStage) : ?>
            <?php
            $studentStage = $studentStages[$itemStage->value] ?? null;
            $studentStageStatus = $studentStage?->getStatus() ?? StageStatus::LOCKED;
            ?>
            <div class="stage-list-item <?= $studentStageStatus->color()->card() ?>">
                <div class="card-header">
                    <h4 class="card-title w-100">
                        <a class="d-flex w-100" data-toggle="collapse" href="<?= '#collapse-' . $itemStage->value ?>">
                            <?= $studentStageStatus->icon()->withExtraCssClass('fa-fw mr-1')->render() ?>
                            <?= $itemStage->label() ?>
                            <?php if ($studentStage) : ?>
                                <i class="icon-caret fas fa-caret-up ml-auto fa-fw"></i>
                            <?php endif; ?>
                        </a>
                    </h4>
                </div>
                <?php if ($studentStage) : ?>
                    <div id="<?= 'collapse-' . $itemStage->value ?>" class="collapse <?= in_array($studentStageStatus, $statusActive) ? 'show' : '' ?>" data-parent="#stage-list">
                        <div class="card-body">
                            <?php
                            $element = 'stages/' . $itemStage->value . '/' . $studentStageStatus->value;

                            if ($this->elementExists($element)) {
                                echo $this->element($element, ['student' => $student, 'studentStage' => $studentStage]);
                            } else {
                                echo '<p>' . __('Sin información a mostrar') . '</p>';
                                echo '<p>' . $this->App->alertMessage() . '</p>';

                                echo $this->devInfo(function () use ($element) {
                                    echo 'Element file not found, the following paths were searched:';
                                    echo $this->Html->nestedList([
                                        'templates/Student/element/' . $element . '.php',
                                        'templates/element/' . $element . '.php',
                                    ]);
                                });
                            }
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    </div>
</div>
