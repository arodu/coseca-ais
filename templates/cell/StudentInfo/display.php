<?php

use Cake\Core\Configure;
?>
<div class="card card-primary card-outline">
    <div class="card-header border-0">
        <h3 class="profile-username text-center"><?= $student->full_name ?></h3>
    </div>
    <div class="card-body p-2">
        <table class="table table-hover">
            <tbody>
                <tr>
                    <th class="text-left narrow"><?= __('Cedula') ?></th>
                    <td class="text-right"><?= h($student->dni) ?></td>
                </tr>
                <tr>
                    <th class="text-left"><?= __('email') ?></th>
                    <td class="text-right"><?= $student->app_user->email ?></td>
                </tr>
                <tr>
                    <th class="text-left"><?= __('Programa') ?></th>
                    <td class="text-right"><?= h($student->tenant->name) ?></td>
                </tr>
                <tr>
                    <th class="text-left"><?= __('Tipo') ?></th>
                    <td class="text-right"><?= $student->getType()->label() ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="card card-success card-outline">
    <div class="card-body p-2">
        <table class="table table-hover ">
            <tbody>
                <tr>
                    <th class="text-left narrow border-0"><?= __('Etapa') ?></th>
                    <td class="text-right border-0"><?= h($student->last_stage->stage_label) ?></td>
                </tr>
                <tr>
                    <th class="text-left"><?= __('Lapso') ?></th>
                    <td class="text-right"><?= $student->last_stage->lapse->name ?></td>
                </tr>
                <tr>
                    <th class="text-left"><?= __('Estado') ?></th>
                    <td class="text-right">
                        <?= $this->Html->tag(
                            'span',
                            $student->last_stage->status_label,
                            ['class' => [$student->last_stage->getStatus()->color()->cssClass('badge'), 'ml-2']]
                        ) ?>
                    </td>
                </tr>
                <tr>
                    <th class="text-left"><?= __('Horas') ?></th>
                    <td>
                        <?= $this->App->progressBar(rand(0, 130), Configure::read('coseca.hours-min')) ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>