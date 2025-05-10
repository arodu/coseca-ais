<?php

use App\Model\Field\StageField;

$project = $student->principal_adscription->institution_project;
$institution = $project->institution;
$tutor = $student->principal_adscription->tutor;
$this->program = $student->tenant->program;
$dates = $student->lapse->getDates(StageField::TRACKING);

$this->assign('contentHeader', $this->element('Documents/formatHeader', ['code' => 'MFS-008']));
?>

<h2>ACTA DE CONCLUSIÓN DEL SERVICIO COMUNITARIO</h2>

<p>
    Hoy, a los <?= $stage->created->day ?> días del mes de <?= $this->App->month($stage->created->month) ?> del año
    <?= $stage->created->year ?>, los miembros de la Comunidad Universitaria y Comunidad Beneficiaria
    involucrados en la ejecución del Proyecto de <?= h($project->name) ?>, desarrollado en la institución
    <?= h($institution->name) ?>, 

    <?php if ($institution->hasAddress()) : ?>
        ubicado en la Parroquia <?= $institution->parish->name ?>, del Municipio <?= $institution->municipality->name ?>
        del Estado <?= $institution->state->name ?>,
    <?php endif; ?>

    en acto público de reflexión, y acompañando a (el/la) Bachiller: <?= $student->full_name ?>, C.I.: <?= $student->dni ?>,
    adscrito al Proyecto antes mencionado, damos fe de: “haber cumplido plena y satisfactoriamente las <?= '120' ?>
    horas mínimas de la prestación del Servicio Comunitario de conformidad con la Ley de Servicio Comunitario del
    Estudiante de Educación Superior, y demás reglamentos que regulan la materia en nuestra Casa de Estudios, en el
    periodo desde el <?= $dates->start_date->format('d/m/Y') ?> hasta el <?= $dates->end_date->format('d/m/Y') ?>. Para los efectos legales pertinentes,
    y en constancia de lo antes expuesto, firman
</p>

<table class="table-footer">
    <tr>
        <td>
            <strong>Tutor (a) Académico (a):</strong> <?= $tutor->name ?><br>
            FIRMA: _____________________
        </td>
        <td>
            C.I. <?= $tutor->dni ?>
        </td>
    </tr>

    <tr>
        <td>
            <strong>Tutor (a) Comunitario (a):</strong> <?= $project->institution->contact_person ?><br>
            FIRMA: _____________________<br>
            SELLO INSTITUCIONAL
        </td>
        <td>
            C.I. 
        </td>
    </tr>

    <tr>
        <td>
            <strong>Estudiante:</strong> <?= $student->full_name ?><br>
            FIRMA: _____________________<br>
        </td>
        <td>
            C.I. <?= $student->dni ?>
        </td>
    </tr>
</table>

<style>
    h2 {
        text-align: center;
        font-size: 15pt;
    }

    p {
        text-indent: 40px;
        text-align: justify;
        font-size: 13pt;
        line-height: 2;
    }

    p.no-ident {
        text-indent: 0;
    }

    .table-footer {
        width: 100%;
        border-collapse: collapse;
        font-size: 13pt;
        line-height: 2;
    }

    .table-footer td {
        text-align: left;
        padding-bottom: 16pt;
        vertical-align: top;
    }
</style>