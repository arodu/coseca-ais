<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Student $student
 */

$this->assign('title', __('Registro de Estudiante'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Registro de Estudiante')],
]);
?>

<div class="card card-primary card-outline">
    <?= $this->Form->create($student) ?>
    <div class="card-body">
        <?= $this->cell('Forms::register', ['student' => $student]) ?>
    </div>

    <div class="card-footer d-flex">
        <div class="ml-auto">
            <?= $this->Button->save() ?>
            <?= $this->Button->cancel(['url' => ['_name' => 'student:home']]) ?>
        </div>
    </div>

    <?= $this->Form->end() ?>
</div>