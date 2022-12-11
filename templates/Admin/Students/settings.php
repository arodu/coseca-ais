<?php

/**
 * @var \App\View\AppView $this
 */

use App\Model\Field\StageStatus;

$this->student_id = $student->id;
$this->active = 'settings';
$this->extend('/Admin/Common/view_student');

$this->assign('title', __('Estudiante'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Estudiantes'), 'url' => ['controller' => 'Students', 'action' => 'index']],
    ['title' => __('Ver'), 'url' => ['controller' => 'Students', 'action' => 'view', $student->id]],
    ['title' => __('Configuración')],
]);
?>

<div class="m-4">
    <div class="alert alert-info">
        Settings
    </div>

    <ul>
        <li>Cambiar de programa</li>
        <li>Cambiar email</li>
        <li>Convalidar servicio comunitario</li>
        <li>Cambiar contraseña</li>
    </ul>
</div>