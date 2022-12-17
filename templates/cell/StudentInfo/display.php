<?php

use Cake\Core\Configure;

$lastStageColor = $student->last_stage->status_obj->color();

?>
<div class="card card-primary card-outline">
    <div class="card-header border-0">
        <h3 class="profile-username text-center"><?= $student->full_name ?></h3>
    </div>
    <div class="card-body">
        <dl>
            <dt class=""><?= __('Cedula') ?></dt>
            <dd class=" text-right mb-2"><?= h($student->dni) ?? '<code>N/A</code>' ?></dd>

            <dt class=""><?= __('email') ?></dt>
            <dd class=" text-right mb-2"><?= h($student->app_user->email) ?? '&nbsp;'  ?></dd>

            <dt class=""><?= __('Programa') ?></dt>
            <dd class=" text-right mb-2"><?= h($student->tenant->name) ?? '&nbsp;'  ?></dd>

            <dt class=""><?= __('Lapso Académico') ?></dt>
            <dd class=" text-right mb-2"><?= h($student->lapse?->name) ?? '<code>N/A</code>'  ?></dd>

            <dt class=""><?= __('Tipo') ?></dt>
            <dd class=" text-right"><?= h($student->type_obj->label()) ?? '&nbsp;'  ?></dd>
        </dl>
    </div>
</div>

<div class="<?= $lastStageColor->cssClass('card') ?> card-outline">
    <div class="card-body">
        <dl>
            <dt class=""><?= __('Etapa') ?></dt>
            <dd class=" text-right mb-2"><?= h($student->last_stage->stage_label) ?? '&nbsp;'  ?></dd>

            <dt class=""><?= __('Ultima actualización') ?></dt>
            <dd class=" text-right mb-2"><?= h($student->last_stage?->modified) ?? '<code>N/A</code>'  ?></dd>

            <dt class=""><?= __('Estado') ?></dt>
            <dd class="text-right mb-2">
                <?= $this->Html->tag(
                    'span',
                    $student->last_stage->status_label,
                    ['class' => [$lastStageColor->cssClass('badge'), 'ml-2']]
                ) ?>
            </dd>

            <dt class=""><?= __('Horas') ?></dt>
            <dd class=" text-right"><?= $this->App->progressBar(rand(0, 130), Configure::read('coseca.hours-min')) ?></dd>
        </dl>
    </div>
</div>