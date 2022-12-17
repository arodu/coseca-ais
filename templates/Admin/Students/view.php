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

<div class="card-body">
    <div class="timeline timeline-inverse">
        <?php foreach ($stageList as $stage) : ?>
            <!-- timeline item -->
            <?php if (empty($stage['studentStage'])) : ?>
                <div>
                    <?= StageStatus::PENDING->icon()->render() ?>
                    <div class="timeline-item">
                        <h3 class="timeline-header"><strong><?= $stage['stageField']->label() ?></strong></h3>
                    </div>
                </div>
            <?php else : ?>
                <?= $this->element('admin/general/' . $stage['stageField']->value, [
                    'studentStage' => $stage['studentStage'],
                    'student' => $student,
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

<?php // debug($student) ?>