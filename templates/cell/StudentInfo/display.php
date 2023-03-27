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
            <dt><?= __('Cedula') ?></dt>
            <dd class=" text-right mb-2"><?= h($student->dni) ?? $this->App->nan() ?></dd>

            <dt><?= __('email') ?></dt>
            <dd class="text-right mb-2"><?= h($student->app_user->email) ?? '&nbsp;' ?></dd>

            <dt><?= __('Programa') ?></dt>
            <dd class="text-right mb-2"><?= h($student->tenant->label) ?? '&nbsp;' ?></dd>

            <dt><?= __('Lapso Académico') ?></dt>
            <dd class="text-right mb-2"><?= h($student->lapse?->name) ?? $this->App->nan() ?></dd>

            <dt><?= __('Tipo') ?></dt>
            <dd class="text-right"><?= h($student->type_obj->label()) ?? '&nbsp;' ?></dd>

            <dt><?= __('Última Sesión') ?></dt>
            <dd class="text-right"><?= h($student->app_user->last_login) ?? $this->App->nan() ?></dd>
        </dl>
    </div>
</div>

<div class="<?= $lastStageColor->card() ?> card-outline">
    <div class="card-body">
        <dl>
            <dt><?= __('Etapa') ?></dt>
            <dd class=" text-right mb-2"><?= h($student->last_stage->stage_label) ?? '&nbsp;'  ?></dd>

            <dt><?= __('Ultima actualización') ?></dt>
            <dd class=" text-right mb-2"><?= h($student->last_stage?->modified) ?? $this->App->nan()  ?></dd>

            <dt><?= __('Estado') ?></dt>
            <dd class="text-right mb-2">
                <?= $this->Html->tag(
                    'span',
                    $student->last_stage->status_label,
                    ['class' => [$lastStageColor->badge(), 'ml-2']]
                ) ?>
            </dd>

            <dt><?= __('Horas') ?></dt>
            <dd class=" text-right"><?= $this->App->progressBar($student->total_hours, Configure::read('coseca.hours-min')) ?></dd>
        </dl>
    </div>
</div>