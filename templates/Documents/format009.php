<?php

use Cake\Utility\Text;


$this->assign('contentHeader', $this->element('Documents/format009Header'));
$this->assign('contentFooter', $this->element('Documents/format009Footer'));
?>

<h2>CONSTANCIA CULMINACIÓN SERVICIO COMUNITARIO</h2>

<p>
    Quienes suscriben, hacen constar por medio de la presente que el (la) ciudadano (a)
    Bachiller: <strong><?= $student->full_name ?></strong>,
    titular de la Cédula de Identidad N° <strong><?= $student->dni ?></strong>,
    estudiante del Área de Ingeniería de Sistemas, CULMINÓ las actividades inherentes a la
    prestación del Servicio Comunitario según lo establecido en la LEY DE SERVICIO
    COMUNITARIO DEL ESTUDIANTE DE EDUCACIÓN SUPERIOR y sus
    REGLAMENTOS, a través de la ejecución del Proyecto: ____________________________________________________________________________ en la(s) Comunidad(es) o Institución: ________________________________________________________, con el apoyo
    del(a) Tutor(a) Académico(a): __________________________________________.
</p>
<p>
    Constancia que se expide a petición de la parte interesada en San Juan de
    los Morros; a los __________ días del mes de __________________ de 20_____.
</p>


<p>
    <strong>Nota:</strong> El estudiante debe presentar esta constancia en la Coordinación de
    Servicio Comunitario para su respectiva validación.
</p>

<style>
    h2 {
        text-align: center;
        font-size: 14pt;
    }

    p {
        text-align: justify;
        font-size: 12pt;
        line-height: 2;
    }
</style>

<?php
// debug($student->toArray());

?>