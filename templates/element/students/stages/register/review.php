<?php

/**
 * @var \App\Model\Entity\Student $student
 */

use Cake\Core\Configure;

//$student = $stageInstance->getStudent();
?>
<h4>Realizado Satisfactoriamente</h4>

<p>En espera por revisión de documentos!</p>

<?php if (Configure::read('debug')) {
    echo '<p>Revisar texto: `templates/element/students/stages/register/review.php`</p>';
}
?>

<hr>
<small class="text-muted">
    <?= __('En espera por revisión de documentos') ?>
</small>
