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
                    <th><?= $this->Html->tag('span', __('Total'), ['class' => 'badge badge-dark']) ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stages as $stage) : ?>
                    <tr>
                        <th><?= $stage->label() ?></th>
                        <?php $sum = 0 ?>
                        <?php foreach ($statuses as $status) : ?>
                            <td><?= $reports[$stage->value . '-' . $status->value] ?? 0 ?></td>
                            <?php $sum += $reports[$stage->value . '-' . $status->value] ?? 0 ?>
                        <?php endforeach; ?>
                        <td><?= $sum ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

