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
    <p><?= __('Estimado Prestador de Servicio Comunitario, estamos complacidos de haberte acompañado hasta el final de tu proceso en el lapso académico 2023-1.  Para acceder a tu planilla 009, te invitamos a imprimirla, y llevarla a nuestra oficina AIS para validarla. Una vez firmada, podrás retirarla para tramitar los procesos inherentes.') ?></p>

    <?= $this->Button->fileReport([
        'url' => [
            'prefix' => 'Student',
            'controller' => 'Documents',
            'action' => 'format009',
            FilePrint::format009($student),
        ],
        'label' => __('Descargar planilla 009'),
        'target' => '_blank',
        'class' => 'btn-sm'
    ]) ?>
<?php endif ?>