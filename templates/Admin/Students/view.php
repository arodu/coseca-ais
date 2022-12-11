<?php

/**
 * @var \App\View\AppView $this
 */

use App\Model\Field\StageStatus;

$this->student_id = $student->id;
$this->active = 'general';
$this->extend('/Admin/Common/view_student');

$this->assign('title', __('Estudiante'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Estudiantes'), 'url' => ['controller' => 'Students', 'action' => 'index']],
    ['title' => __('Ver')],
]);
?>

<div class="m-4">
    <div class="timeline timeline-inverse">
        <?php foreach ($listStages as $stage) : ?>
            <?php
            $studentStage = $studentStages[$stage->value] ?? null;
            ?>
            <!-- timeline item -->
            <?php if (empty($studentStage)) : ?>
                <div>
                    <?= StageStatus::PENDING->icon()->render() ?>
                    <div class="timeline-item">
                        <h3 class="timeline-header"><strong><?= $stage->label() ?></strong></h3>
                    </div>
                </div>
            <?php else : ?>
                <?php
                $element = 'admin/general/' . $stage->value;
                echo $this->element($element, [
                    'stage' => $stage,
                    'studentStage' => $studentStage,
                ]);
                ?>
            <?php endif; ?>
            <!-- END timeline item -->
        <?php endforeach; ?>
        <div>
            <i class="far fa-clock bg-gray"></i>
        </div>
    </div>
</div>