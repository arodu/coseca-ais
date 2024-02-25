<?php

/** @var \App\Model\Entity\StudentStage $studentStage */
/** @var \App\Model\Entity\Student $student */
/** @var \App\View\AppView $this */

use App\Model\Field\StageStatus;
use App\Utility\FilePrint;

$status = $studentStage->enum('status');
$color = $status->color();
$icon = $status->icon();

$this->set('studentStage', $studentStage);
$this->extend('/Admin/Common/timeline_item');

$this->start('actions');
echo $this->Button->confirm([
    'label' => __('Cerrar Conclusiones'),
    'url' => [
        'controller' => 'Endings',
        'action' => 'closeStage',
        $studentStage->student_id,
        'prefix' => 'Admin/Stage'
    ],
    'confirm' => __('¿Está seguro de cerrar la etapa de conclusiones?'),
    'class' => 'btn-sm',
]);

if ($studentStage->statusIs([StageStatus::WAITING, StageStatus::SUCCESS])) {
    echo $this->Button->report([
        'label' => __('Planilla 009'),
        'url' => [
            'prefix' => 'Admin',
            'controller' => 'Documents',
            'action' => 'format009',
            $studentStage->student_id,
            FilePrint::format009($student),
        ],
        'class' => 'btn-sm ml-2',
    ]);
}

$this->end();

?>

<?php if (!$student->hasPrincipalAdscription()) : ?>
    <div class="alert alert-warning p-2">
        <?= __('El estudiante no tiene una adscripción principal.') ?>
        <?= $this->Html->link(
            __('Ver Proyectos'),
            ['controller' => 'Students', 'action' => 'adscriptions', $student->id, 'prefix' => 'Admin'],
        ) ?>
    </div>
<?php endif ?>