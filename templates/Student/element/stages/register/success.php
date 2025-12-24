<?php

/**
 * @var \App\Model\Entity\Student $student
 */
?>
<dl class="row">
    <dt class="col-sm-3 text-right"><?= __('Cédula') ?></dt>
    <dd class="col-sm-7"><?= h($student->dni) ?> </dd>
    
    <dt class="col-sm-3 text-right"><?= __('Nombres') ?></dt>
    <dd class="col-sm-7"><?= h($student->first_name) ?> </dd>

    <dt class="col-sm-3 text-right"><?= __('Apellidos') ?></dt>
    <dd class="col-sm-7"><?= h($student->last_name) ?> </dd>

    <dt class="col-sm-3 text-right"><?= __('Correo electrónico') ?></dt>
    <dd class="col-sm-7"><?= h($student->email) ?> </dd>

    <dt class="col-sm-3 text-right"><?= __('Programa') ?></dt>
    <dd class="col-sm-7"><?= h($student->tenant->label) ?> </dd>

    <dt class="col-sm-3 text-right"><?= __('Teléfono') ?></dt>
    <dd class="col-sm-7"><?= h($student->student_data?->phone) ?> </dd>

    <dt class="col-sm-3 text-right"><?= __('Área de Interés') ?></dt>
    <dd class="col-sm-7"><?= h($student->student_data?->interest_area?->name) ?> </dd>

    <dt class="col-sm-3 text-right"><?= __('Registro') ?></dt>
    <dd class="col-sm-7"><?= h($student->created) ?> </dd>
</dl>