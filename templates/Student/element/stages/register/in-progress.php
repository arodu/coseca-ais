<?php 
/**
 * @var \App\Model\Entity\Student $student
 * @var \App\Model\Entity\StudentStage $studentStage
 */

use App\Enum\ActionColor;
use App\Enum\StatusDate;
use App\Model\Field\StageField;

//  Import Exceptions of CakePHP
use Cake\Http\Exception\NotFoundException;
try{ 
    $dates = $student->getCurrentLapse()->getDates(StageField::REGISTER);
}catch(Exception $e){
    throw new NotFoundException(__("Actualmente no se encuentra un período activo, contacte la Coordinación de Servicio Comunitario. /logout")); //logout for student no lapses
}
?>

<?php if (empty($dates->status)) : ?>
    <p><?= __('No existe fecha de registro') ?></p>
    <p><?= $this->App->alertMessage() ?></p>

<?php elseif ($dates->status->is(StatusDate::IN_PROGRESS)) : ?>
    <p><?= __('Fecha de registro: {0}', $dates->show_dates) ?></p>
    <?= $this->Button->edit([
        'url' => ['_name' => 'student:register'],
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