<?php 
/**
 * @var \App\Model\Entity\Student $student
 * @var \App\Model\Entity\StudentStage $studentStage
 */

use App\Enum\ActionColor;
use App\Enum\StatusDate;
use App\Model\Field\StageField;

$dates = $student->getCurrentLapse()->getDates(StageField::REGISTER);

?>

<?php if (empty($dates->status)) : ?>
    <p><?= __('No existe fecha de registro') ?></p>
    <p><?= $this->App->alertMessage() ?></p>

<?php elseif ($dates->status->is(StatusDate::IN_PROGRESS)) : ?>
    <p><?= __('Fecha de registro: {0}', $dates->show_dates) ?></p>
    <?= $this->Button->edit([
        'url' => ['controller' => 'RegisterStage', 'action' => 'edit', 'prefix' => 'Student'],
        'label' => __('Formulario de registro'),
        'actionColor' => ActionColor::SUBMIT,
    ]) ?>

<?php elseif ($dates->status->is(StatusDate::PENDING)) : ?>
    <p><?= __('Fecha de registro: {0}', $dates->show_dates) ?></p>
    <p><?= $this->App->alertMessage() ?></p>

<?php elseif ($dates->status->is(StatusDate::TIMED_OUT)) : ?>
    <p><?= __('Ya pasó el período de registro') ?></p>
    <p><?= $this->App->alertMessage() ?></p>

<?php endif; ?>