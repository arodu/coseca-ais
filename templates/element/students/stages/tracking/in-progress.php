<?php
/**
 * @var \App\Model\Entity\Student $student
 * @var \App\Model\Entity\StudentStage $studentStage
 */

use App\Model\Field\StageStatus;

?>

<?php if (empty($student->student_adscriptions)) : ?>
    <p><?= __('El estudiante no tiene proyectos adscritos.') ?></p>
    <p><?= __('Comuniquese con la coordinación de servicio comunitario para mas información.') ?></p>
<?php else : ?>
    <?php foreach ($student->student_adscriptions as $studentAdscription) : ?>
        <?php
        $institution = $studentAdscription->institution_project->institution;
        $project = $studentAdscription->institution_project;
        ?>
        <div class="col-12">
            <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                    <?= $project->name ?>
                </div>
                <div class="card-body pt-0">
                </div>
                <div class="card-footer">
                    <div class="text-right">
                        <?= $this->Html->link(
                            __('Seguimiento'),
                            ['controller' => 'StudentTracking', 'action' => 'index', $studentAdscription->id],
                            ['class' => 'btn btn-sm btn-primary', 'target' => '_blank']
                        ) ?> 
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
