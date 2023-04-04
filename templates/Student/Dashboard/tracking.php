<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Student $student
 */

?>
<?php
$this->assign('title', __('Registro de Actividades'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => '/'],
    ['title' => __('Registro de Actividades')],
]);
?>


<?= $trackingView->render() ?>
