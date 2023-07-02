<?php
$this->headerHeight = 130;

$student = $adscription->student;
$project = $adscription->institution_project;
$tutor = $adscription->tutor;
$institution = $project->institution;
?>

<table style="width:100%">
    <tr>
        <td colspan="3" class="text-right">
            <strong>MFS-007</strong>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?= __('Apellidos y Nombres') ?>: <?= __('{0}, {1}', $student->last_name, $student->first_name) ?>
        </td>
    </tr>
    <tr>
        <td colspan=2>
            <?= __('Cedula') ?>: <?= h($student->dni) ?>
        </td>
        <td>
            <?= __('Lapso Académico') ?>: <?= h($student->lapse->name) ?>
        </td>
    </tr>
    <tr>
        <td colspan=3>
            <?= __('Nombre de la Comunidad/Institución/Dependencia Beneficiaria') ?>: <?= h($institution->name) ?>
        </td>
    </tr>
    <tr>
        <td colspan=3>
            <?= __('Título del proyecto') ?>: <?= h($project->name) ?>
        </td>
    </tr>
    <tr>
        <td>
            <?= __('Tutor(a) Académico(a)') ?>: <?= h($tutor->name) ?>
        </td>
        <td>
            <?= __('Cedula') ?>: <?= h($tutor->dni) ?>
        </td>
        <td>
            <?= __('Teléfono') ?>: <?= h($tutor->phone) ?>
        </td>
    </tr>
    <tr>
        <td>
            <?= __('Tutor(a) Comunitario(a)') ?>: <?= h($institution->contact_person) ?>
        </td>
        <td>
            <?= __('Cedula') ?>: <?= h('') ?>
        </td>
        <td>
            <?= __('Teléfono') ?>: <?= h($institution->contact_phone) ?>
        </td>
    </tr>
</table>