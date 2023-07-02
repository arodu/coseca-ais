<?php

$this->footerHeight = 100;
$this->assign('contentHeader', $this->element('Documents/format007Header', ['adscription' => $adscription]));
$this->assign('contentFooter', $this->element('Documents/format007Footer', ['validationToken' => $validationToken]));

$tracking = $adscription->student_tracking;
$num = 1;

?>

<table border="1">
    <thead>
        <tr>
            <th>#</th>
            <th><?= __('Fecha') ?></th>
            <th><?= __('Horas cumplidas') ?></th>
            <th><?= __('Actividades realizadas') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tracking as $track) : ?>
            <tr>
                <td class="text-center"><?= h($num) ?></td>
                <td class="text-center"><?= h($track->date) ?></td>
                <td class="text-center"><?= h($track->hours) ?></td>
                <td><?= h($track->description) ?></td>
            </tr>
            <?php $num++; ?>
        <?php endforeach; ?>
    </tbody>
</table>

<br>

<table border="1">
    <tbody>
        <tr>
            <th class="text-center" style="width: 50%"><?= __('Cantidad de actividades') ?></th>
            <td class="text-center" style="width: 50%"><?= $trackingInfo['trackingCount'] ?? $this->App->nan() ?></td>
        </tr>
        <tr>
            <th class="text-center" style="width: 50%"><?= __('Primera actividad') ?></th>
            <td class="text-center" style="width: 50%"><?= $trackingInfo['trackingFirstDate'] ?? $this->App->nan() ?></td>
        </tr>
        <tr>
            <th class="text-center" style="width: 50%"><?= __('Ultima actividad') ?></th>
            <td class="text-center" style="width: 50%"><?= $trackingInfo['trackingLastDate'] ?? $this->App->nan() ?></td>
        </tr>
        <tr>
            <th class="text-center" style="width: 50%"><?= __('Horas completadas') ?></th>
            <td class="text-center" style="width: 50%"><?= $trackingInfo['totalHours'] ?? $this->App->nan() ?></td>
        </tr>
    </tbody>
</table>