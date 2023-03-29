<?php

/**
 * @var \App\Model\Entity\Student $student
 * @var \App\Model\Entity\StudentStage $studentStage
 */

use App\Enum\ActionColor;
use App\Model\Field\AdscriptionStatus;
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
        $tutor = $studentAdscription->tutor;
        ?>

        <div class="card">
            <div class="card-header d-flex">
                <h3 class="card-title">
                    <?= h($studentAdscription->institution_project->label_name) ?>
                </h3>
                <div class="ml-auto">
                    <?= $this->App->badge($studentAdscription->status_obj) ?>
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
                    <div></div>
                    <div class="ml-auto">
                        <?php if ($studentAdscription->status_obj->is(AdscriptionStatus::PENDING)) : ?>
                            <!-- <?= $this->Html->link(
                                        __('Planilla de Adscripción'),
                                        ['controller' => 'StudentDocuments', 'action' => 'download', $studentAdscription->student_document->token],
                                        ['class' => ActionColor::REPORT->btn('btn-sm'), 'target' => '_blank']
                                    ) ?> -->
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>




<?php /* if (empty($student->student_adscriptions)) : ?>
    <p><?= __('El estudiante no tiene proyectos adscritos.') ?></p>
    <p><?= __('Comuníquese con la Coordinación de Servicio Comunitario para más información.') ?></p>
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

                <?php if ($studentStage->status_obj->is(StageStatus::REVIEW)) : ?>
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
<?php endif; */ ?>