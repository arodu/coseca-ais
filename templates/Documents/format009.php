<?php

$project = $student->principal_adscription->institution_project;
$tutor = $student->principal_adscription->tutor;

$this->assign('contentHeader', $this->element('Documents/format009Header'));
$this->assign('contentFooter', $this->element('Documents/format009Footer'));
$this->program = $student->tenant->program;
?>

<h2>CONSTANCIA CULMINACIÓN SERVICIO COMUNITARIO</h2>

<p>
    Quienes suscriben, hacen constar por medio de la presente que el(la) ciudadano(a)
    Bachiller: <strong><?= $student->full_name ?></strong>,
    titular de la Cédula de Identidad N° <strong><?= $student->dni ?></strong>,
    estudiante del <?= $student->tenant->program->area_print_label ?>,
    <strong>CULMINÓ</strong> las actividades inherentes a la prestación del Servicio Comunitario
    según lo establecido en la <strong>LEY DE SERVICIO COMUNITARIO DEL ESTUDIANTE DE EDUCACIÓN SUPERIOR</strong> y sus
    <strong>REGLAMENTOS</strong>, a través de la ejecución del Proyecto: <strong><?= $project->name ?></strong>,
    en la(s) Comunidad(es) o Institución: <strong><?= $project->institution->name ?></strong>,
    con el apoyo del(a) Tutor(a) Académico(a): <strong><?= $tutor->name ?></strong>.
</p>

<p>
    Constancia que se expide a petición de la parte interesada en San Juan de los Morros;
    a los <?= $endingStage->created->day ?> días del mes de <?= $this->App->month($endingStage->created->month) ?> de <?= $endingStage->created->year ?>.
</p>

<p>
    <strong>Nota:</strong> El estudiante debe presentar esta constancia en la Coordinación de
    Servicio Comunitario para su respectiva firma, sello y validación.
</p>

<p class="no-ident">
    Folio ______ Número ______ <br>
    Año: <?= $endingStage->created->year ?>
</p>

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
</style>