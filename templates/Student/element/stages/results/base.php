<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Student $student
 * @var \App\Model\Entity\StudentStage $studentStage
 */

use App\Utility\FilePrint;

?>

<?php if (!$student->hasPrincipalAdscription()) : ?>
    <p><?= __('Ha ocurrido un problema en la consolidación de los documentos') ?></p>
    <p><?= $this->App->alertMessage() ?></p>
<?php else : ?>
    <?= $this->Button->fileReport([
        'url' => [
            'prefix' => 'Student',
            'controller' => 'Documents',
            'action' => 'format008',
            FilePrint::format008($student),
        ],
        'label' => __('Descargar planilla 008'),
        'target' => '_blank',
        'class' => 'btn-sm'
    ]) ?>
<?php endif ?>