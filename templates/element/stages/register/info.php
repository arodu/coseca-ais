<?php

use App\Model\Field\Stages;

?>

<?php if ($status === Stages::STATUS_IN_PROGRESS): ?>
    <p>Formulario de Registro</p>
    <?= $this->Html->link('Registro', ['controller' => 'RegisterStage', 'action' => 'edit', 'prefix' => 'Student'], ['class' => 'btn btn-primary']) ?>
<?php endif; ?>