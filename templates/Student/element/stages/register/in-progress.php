<?php 
/**
 * @var \App\Model\Entity\Student $student
 * @var \App\Model\Entity\StudentStage $studentStage
 */

use App\Enum\StatusDate;
use App\Model\Field\StageField;

$dates = $student->getCurrentLapse()->getDates(StageField::REGISTER);

?>

<?php if (empty($dates->status)) : ?>
    <p><?= __('No existe fecha de registro') ?></p>
    <p><?= $this->App->alertMessage() ?></p>

<?php elseif ($dates->status->is(StatusDate::IN_PROGRESS)) : ?>
    <?= $this->Html->link('Formulario de registro', ['controller' => 'RegisterStage', 'action' => 'edit', 'prefix' => 'Student'], ['class' => 'btn btn-primary']) ?>

<?php elseif ($dates->status->is(StatusDate::PENDING)) : ?>
    <p><?= __('Fecha de registro: {0}', $dates->show_dates) ?></p>
    <p><?= $this->App->alertMessage() ?></p>

<?php elseif ($dates->status->is(StatusDate::TIMED_OUT)) : ?>
    <p><?= __('Ya pasó el período de registro') ?></p>
    <p><?= $this->App->alertMessage() ?></p>

<?php endif; ?>