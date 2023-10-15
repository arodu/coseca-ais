<?php

use App\Model\Field\StageField;
use App\Model\Field\StageStatus;

$statuses = [
    StageStatus::WAITING,
    StageStatus::IN_PROGRESS,
    StageStatus::REVIEW,
    StageStatus::SUCCESS,
];

$stages = [
    StageField::REGISTER,
    StageField::COURSE,
    StageField::ADSCRIPTION,
    StageField::TRACKING,
    StageField::RESULTS,
    StageField::ENDING,
]
?>

<div class="row">
    <div class="col-md-8">
        <table class="table table-borderless table-hover">
            <thead>
                <tr>
                    <th><?= __('Etapa / Estado') ?></th>
                    <?php foreach ($statuses as $status) : ?>
                        <th><?= $this->App->badge($status) ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stages as $stage) : ?>
                    <tr>
                        <th><?= $stage->label() ?></th>
                        <?php foreach ($statuses as $status) : ?>
                            <td><?= $reports[$stage->value . '-' . $status->value] ?? 0 ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

