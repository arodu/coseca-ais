<?php
/**
 * @var \App\Model\Entity\Student $student
 * @var \App\Model\Entity\StudentStage $studentStage
 */

use App\Model\Field\StageStatus;

?>

<?php if (empty($student->student_adscriptions)) : ?>
    <p><?= __('El estudiante tiene un proyecto adscrito.') ?></p>
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
                    <?= $institution->name ?>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-7">
                            <h2 class="lead"><b><?= $institution->contact_person ?></b></h2>
                            <dl>
                                <dt><?= __('Telefóno') ?></dt>
                                <dd><?= $institution->contact_phone ?></dd>
                                <dt><?= __('Email') ?></dt>
                                <dd><?= $institution->contact_email ?></dd>
                            </dl>
                        </div>
                        <div class="col-5">
                            <dl>
                                <dt><?= __('Proyecto') ?></dt>
                                <dd><?= $project->name ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <?php if ($studentStage->status_obj->is(StageStatus::REVIEW)): ?>
                <div class="card-footer">
                    <div class="text-right">
                        <?= $this->Html->link(
                            __('Planilla de Adscripción'),
                            ['controller' => 'StudentDocuments', 'action' => 'download', $studentAdscription->student_document->token],
                            ['class' => 'btn btn-sm btn-primary', 'target' => '_blank']
                        ) ?> 
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
