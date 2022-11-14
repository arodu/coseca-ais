<?php

use App\Enum\StageStatus;
use App\Model\Field\Stages;
use Cake\Core\Configure;

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
            <?php
                $studentStage = $studentStages[$stageKey] ?? null;
                $studentStageStatus = $studentStage->status ?? null;
            ?>
            <div class="card <?= $this->App->statusColor($studentStageStatus, 'card') ?>">
                <div class="card-header">
                    <h4 class="card-title w-100">
                        <a class="d-flex w-100" data-toggle="collapse" href="<?= '#collapse-' . $stageKey ?>">
                            <?= $this->App->statusIcon($studentStageStatus, true, 'fa-fw mr-1') ?>
                            <?= $baseStage[Stages::DATA_LABEL] ?>
                            <?php if ($studentStage) : ?>
                                <i class="fas fa-caret-down ml-auto"></i>
                            <?php endif; ?>
                        </a>
                    </h4>
                </div>

                <?php if ($studentStage) : ?>
                    <div id="<?= 'collapse-' . $stageKey ?>" class="collapse <?= $this->App->statusActive($studentStageStatus) ?>" data-parent="#accordion">
                        <div class="card-body">
                            <?php
                            $element = 'stages/' . $stageKey . '/' . $studentStageStatus;
                            if ($this->elementExists($element)) {
                                echo $this->element($element, ['stageInstance' => $studentStage->getStageInstance()]);
                            } else {
                                echo $this->Html->tag('div', __('Sin información a mostrar'), ['class' => 'alert alert-warning shadow p-2']);
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


<?php
debug(StageStatus::cases());
debug(StageStatus::toArray());
debug(StageStatus::from('waiting')->label());
?>
