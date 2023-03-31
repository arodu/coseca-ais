<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Student $student
 */

use App\Enum\Gender;
use App\Utility\Students;

?>
<?php
$this->assign('title', __('Registro de Actividades'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Registro de Actividades')],
]);
?>

<div class="card card-primary card-outline">
    <div class="card-body">
    </div>
</div>