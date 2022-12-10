<?php 
/**
 * @var \App\Stage\RegisterStage $stageInstance
 */

use App\Enum\StatusDate;

$dates = $stageInstance->getDates();
?>


<?php if ($dates->status == StatusDate::IN_PROGRESS) : ?>
    <p>Formulario de Registro</p>
    <?= $this->Html->link('Registro', ['controller' => 'RegisterStage', 'action' => 'edit', 'prefix' => 'Student'], ['class' => 'btn btn-primary']) ?>

<?php elseif ($dates->status == StatusDate::PENDING) : ?>
    <p><?= __('Fecha de registro: {0}', $dates->show_dates) ?></p>
    <p><?= __('Comuniquese con la coordinación de servicio comunitario para mas información.') ?></p>
<?php elseif ($dates->status == StatusDate::TIMED_OUT) : ?>
    <p><?= __('Ya pasó el periodo de registro') ?></p>
    <p><?= __('Comuniquese con la coordinación de servicio comunitario para mas información.') ?></p>
<?php else : ?>
    <p><?= __('No existe fecha de registro') ?></p>
    <p><?= __('Comuniquese con la coordinación de servicio comunitario para mas información.') ?></p>
<?php endif; ?>


<?php //debug($dates) ?>