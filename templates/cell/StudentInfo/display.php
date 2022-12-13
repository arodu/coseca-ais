<?php

use Cake\Core\Configure;

$lastStageColor = $student->last_stage->status_obj->color();

?>
<div class="card card-primary card-outline">
    <div class="card-header border-0">
        <h3 class="profile-username text-center"><?= $student->full_name ?></h3>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-4"><?= __('Cedula') ?></dt>
            <dd class="col-sm-8 text-right mb-4"><?= h($student->dni) ?? '<code>N/A</code>' ?></dd>

            <dt class="col-sm-4"><?= __('email') ?></dt>
            <dd class="col-sm-8 text-right mb-4"><?= h($student->app_user->email) ?? '&nbsp;'  ?></dd>

            <dt class="col-sm-4"><?= __('Programa') ?></dt>
            <dd class="col-sm-8 text-right mb-4"><?= h($student->tenant->name) ?? '&nbsp;'  ?></dd>

            <dt class="col-sm-4"><?= __('Tipo') ?></dt>
            <dd class="col-sm-8 text-right"><?= h($student->type_obj->label()) ?? '&nbsp;'  ?></dd>
        </dl>
    </div>
</div>

<div class="<?= $lastStageColor->cssClass('card') ?> card-outline">
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-4"><?= __('Etapa') ?></dt>
            <dd class="col-sm-8 text-right mb-4"><?= h($student->last_stage->stage_label) ?? '&nbsp;'  ?></dd>

            <dt class="col-sm-4"><?= __('Lapso') ?></dt>
            <dd class="col-sm-8 text-right mb-4"><?= h($student->last_stage->lapse->name) ?? '&nbsp;'  ?></dd>

            <dt class="col-sm-4"><?= __('Estado') ?></dt>
            <dd class="col-sm-8 text-right mb-4">
                <?= $this->Html->tag(
                    'span',
                    $student->last_stage->status_label,
                    ['class' => [$lastStageColor->cssClass('badge'), 'ml-2']]
                ) ?>
            </dd>

            <dt class="col-sm-4"><?= __('Horas') ?></dt>
            <dd class="col-sm-8 text-right"><?= $this->App->progressBar(rand(0, 130), Configure::read('coseca.hours-min')) ?></dd>
        </dl>
    </div>
</div>