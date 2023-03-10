<?php 
/**
 * @var \App\Stage\RegisterStage $stageInstance
 */

use App\Enum\StatusDate;
use App\Model\Field\StageField;

$dates = $student->getCurrentLapse()->getDates(StageField::REGISTER);

?>

<?php if (empty($dates->status)) : ?>
    <p><?= __('No existe fecha de registro') ?></p>
    <p><?= __('Comuniquese con la coordinación de servicio comunitario para mas información.') ?></p>

<?php elseif ($dates->status->is(StatusDate::IN_PROGRESS)) : ?>
    <p>Formulario de Registro</p>
    <?= $this->Html->link('Registro', ['controller' => 'RegisterStage', 'action' => 'edit', 'prefix' => 'Student'], ['class' => 'btn btn-primary']) ?>

<?php elseif ($dates->status->is(StatusDate::PENDING)) : ?>
    <p><?= __('Fecha de registro: {0}', $dates->show_dates) ?></p>
    <p><?= __('Comuniquese con la coordinación de servicio comunitario para mas información.') ?></p>

<?php elseif ($dates->status->is(StatusDate::TIMED_OUT)) : ?>
    <p><?= __('Ya pasó el periodo de registro') ?></p>
    <p><?= __('Comuniquese con la coordinación de servicio comunitario para mas información.') ?></p>

<?php endif; ?>

<hr>
<small>
    <?= __('En espera por registro de datos') ?>
</small>
