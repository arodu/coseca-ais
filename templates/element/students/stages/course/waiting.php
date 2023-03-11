<?php 
/**
 * @var \App\Model\Entity\Student $student
 * @var \App\Model\Entity\StudentStage $studentStage
 */

use App\Enum\StatusDate;
use App\Model\Field\StageField;

$dates = $student->getCurrentLapse()->getDates(StageField::COURSE);
?>

<?php if (empty($dates->status)) : ?>
    <p><?= __('En espera de la fecha del curso de Servicio Comunitario') ?></p>
    <p><?= __('Comuniquese con la coordinación de servicio comunitario para mas información.') ?></p>

<?php else : ?>
    <p><?= __('Fecha del taller de servicio comunitario: {0} <small>({1})</small>', $dates->show_dates, $dates->status->label()) ?></p>
    <p><?= __('Comuniquese con la coordinación de servicio comunitario para mas información.') ?></p>

<?php endif; ?>
