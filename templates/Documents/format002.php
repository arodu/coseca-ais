<?php

use Cake\I18n\FrozenDate;
$this->program = $student->tenant->program;
$date = $student->student_course->date;
$today = FrozenDate::now();

$this->assign('contentHeader', $this->element('Documents/format002Header'));
$this->assign('contentFooter', $this->element('Documents/format002Footer'));
?>

<h2>CONSTANCIA APROBACIÓN TALLER SERVICIO COMUNITARIO</h2>
<br><br>
<p>
    Quienes suscriben, hacen constar por medio de la presente que el(la) ciudadano(a)
    Bachiller: <strong><?= h($student->full_name) ?></strong>, titular de la <strong>Cédula de
        Identidad N° <?= h($student->dni) ?></strong>, estudiante del <?= $student->tenant->program->area->print_label ?>, <strong>CURSÓ Y
        APROBÓ</strong> el taller: <strong>INTRODUCCIÓN AL SERVICIO COMUNITARIO</strong>, dictado en
    fecha: <?= $date->day ?> de <?= $this->App->month($date->month) ?> del año <?= $date->year ?>, con una duración de 08 horas académicas, de
    acuerdo a lo establecido en la <strong>Ley de Servicio Comunitario Del Estudiante de
        Educación Superior y el Reglamento de Servicio Comunitario del Estudiante
        de la Universidad Nacional Experimental de los Llanos Centrales “Rómulo Gallegos”</strong>.
</p>

<p>
    Constancia que se expide a petición de la parte interesada en San Juan de los Morros;
    a los <?= $today->day ?> días del mes de <?= $this->App->month($today->month) ?> de <?= $today->year ?>.
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
