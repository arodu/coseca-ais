<?php

/**
 * @var \App\Model\Entity\Student $student
 * @var \App\Model\Entity\StudentStage $studentStage
 */

use App\Enum\ActionColor;
use App\Model\Field\AdscriptionStatus;
?>

<?php if (empty($student->student_adscriptions)) : ?>
    <p><?= __('El estudiante no tiene proyectos adscritos.') ?></p>
    <p><?= $this->App->alertMessage() ?></p>
<?php else : ?>
    <?php foreach ($student->student_adscriptions as $studentAdscription) : ?>
        <?php
        $institution = $studentAdscription->institution_project->institution;
        $project = $studentAdscription->institution_project;
        $tutor = $studentAdscription->tutor;
        ?>

        <div class="card">
            <div class="card-header d-flex">
                <h3 class="card-title">
                    <?= h($studentAdscription->institution_project->label_name) ?>
                </h3>
                <div class="ml-auto">
                    <?= $this->App->badge($studentAdscription->enum('status')) ?>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <dl class="row">
                            <dt class="col-sm-4"><?= __('Institución') ?></dt>
                            <dd class="col-sm-8"><?= $institution->name ?></dd>
                            <dt class="col-sm-4"><?= __('Tutor Institucional') ?></dt>
                            <dd class="col-sm-8"><?= $institution->contact_person ?></dd>
                            <dt class="col-sm-4"><?= __('Teléfono') ?></dt>
                            <dd class="col-sm-8"><?= $institution->contact_phone ?></dd>
                            <dt class="col-sm-4"><?= __('Email') ?></dt>
                            <dd class="col-sm-8"><?= $institution->contact_email ?></dd>
                        </dl>
                    </div>
                    <div class="col">
                        <dl class="row">
                            <dt class="col-sm-4"><?= __('Proyecto') ?></dt>
                            <dd class="col-sm-8"><?= $project->name ?></dd>
                            <dt class="col-sm-4"><?= __('Tutor Académico') ?></dt>
                            <dd class="col-sm-8"><?= $tutor->name ?></dd>
                            <dt class="col-sm-4"><?= __('Teléfono') ?></dt>
                            <dd class="col-sm-8"><?= $tutor->phone ?></dd>
                            <dt class="col-sm-4"><?= __('Email') ?></dt>
                            <dd class="col-sm-8"><?= $tutor->email ?></dd>
                        </dl>
                    </div>

                </div>

                <div class="d-flex">
                    <div class="ml-auto">
                        <?php /* // @todo activar cuando los reportes esten activos
                            if ($studentAdscription->enum('status')?->is(AdscriptionStatus::PENDING)) : ?>
                            <!-- <?= $this->Button->report([
                                'label' => __('Planilla de adscripción'),
                                'url' => ['controller' => 'StudentDocuments', 'action' => 'download', $studentAdscription->student_document->token],
                                'class' => 'btn-sm',
                            ]) ?> -->
                        <?php endif  */ ?>
                    </div>
                </div>
            </div>
        </div>
<?php endforeach; ?>
<?php endif; ?>