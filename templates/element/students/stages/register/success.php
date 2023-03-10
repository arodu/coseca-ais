<?php 
/**
 * @var \App\Model\Entity\Student $student
 */
?>
<h4>Realizado Satisfactoriamente</h4>

<dl>
    <dt><?= __('Cedula') ?></dt>
    <dd><?= $student->dni ?></dd>

    <dt><?= __('Nombres') ?></dt>
    <dd><?= $student->first_name ?></dd>

    <dt><?= __('Apellidos') ?></dt>
    <dd><?= $student->last_name ?></dd>

    <dt><?= __('Registro') ?></dt>
    <dd><?= $student->created ?></dd>
</dl>

<hr>
<small>
    <?= __('Estado') . ': ' . 'realizado' ?>
</small>
