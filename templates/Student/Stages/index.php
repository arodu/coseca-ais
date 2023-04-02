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
            $studentStageStatus = $studentStage?->status_obj ?? StageStatus::LOCKED;
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
                            $element = 'students/stages/' . $itemStage->value . '/' . $studentStageStatus->value;
                            if ($this->elementExists($element)) {
                                echo $this->element($element, ['student' => $student, 'studentStage' => $studentStage]);
                            } else {
                                echo '<p>' . __('Sin información a mostrar') . '</p>';
                                echo '<p>' . __('Comuníquese con la Coordinación de Servicio Comunitario para más información.') . '</p>';
                                if (Configure::read('debug')) {
                                    echo '<p>If you want to customize this message, create <em>templates/element/' . $element . '.php</em></p>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    </div>
</div>
