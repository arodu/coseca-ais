<?php

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
