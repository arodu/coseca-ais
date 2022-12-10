<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StudentStage $studentStage
 */

use App\Model\Field\StageStatus;

?>
<?php
$this->assign('title', __('Edit Student Stage'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => 'List Student Stages', 'url' => ['action' => 'index']],
    ['title' => 'View', 'url' => ['action' => 'view', $studentStage->id]],
    ['title' => 'Edit'],
]);
?>

<div class="row">
    <div class="col-md-3">
        <?= $this->cell('StudentInfo', ['student_id' => $studentStage->student_id]) ?>
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="card card-primary card-outline">
            <?= $this->Form->create($studentStage) ?>
            <div class="card-body">
                <?php
                echo $this->Form->control('stage', ['readonly' => true]);
                echo $this->Form->control('lapse_id', ['options' => $lapses]);
                echo $this->Form->control('status', ['options' => StageStatus::toListLabel()]);
                ?>
            </div>

            <div class="card-footer d-flex">
                <div class="ml-auto">
                    <?= $this->Form->button(__('Guardar')) ?>
                    <?= $this->Html->link(__('Cancelar'), ['controller' => 'Students', 'action' => 'view', $studentStage->student_id], ['class' => 'btn btn-default']) ?>
                </div>
            </div>

            <?= $this->Form->end() ?>
        </div>
    </div>
</div>