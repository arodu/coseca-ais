<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Student $student
 */

use App\Enum\Gender;
use App\Utility\Students;

?>
<?php
$this->assign('title', __('Registro de Estudiante'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Registro')],
]);
?>

<div class="card card-primary card-outline">
    <?= $this->Form->create($student) ?>
    <div class="card-body">
        <?= $this->element('form/register', ['student' => $student]) ?>
    </div>

    <div class="card-footer d-flex">
        <div class="ml-auto">
            <?= $this->Form->button(__('Guardar'), ['class' => 'btn btn-primary']) ?>
            <?= $this->Html->link(__('Cancel'), ['controller' => 'Stages', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <?= $this->Form->end() ?>
</div>
