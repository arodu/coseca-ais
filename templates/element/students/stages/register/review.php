<?php
/**
 * @var \App\Model\Entity\Student $student
 * @var \App\Model\Entity\StudentStage $studentStage
 */

use Cake\Core\Configure;

//$student = $stageInstance->getStudent();
?>

<p><?= __('En espera de revisión de documentos.') ?></p>
<p><?= $this->App->alertMessage() ?></p>