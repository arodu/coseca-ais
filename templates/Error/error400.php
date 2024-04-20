<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Database\StatementInterface $error
 * @var string $message
 * @var string $url
 */
use Cake\Core\Configure;
use Cake\Error\Debugger;

$this->layout = 'error';

if (Configure::read('debug')) :
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error400.php');

    $this->start('file');
?>
<?php if (!empty($error->queryString)) : ?>
    <p class="notice">
        <strong>SQL Query: </strong>
        <?= h($error->queryString) ?>
    </p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?php Debugger::dump($error->params) ?>
<?php endif; ?>
<?= $this->element('auto_table_warning') ?>
<?php

$this->end();
endif;
?>

<?php 
//Format $message to return back or logout

    $back = 'javascript:history.back()'; //to return back

    if(strstr($message, '/logout')){            //exist?
        $back = explode(". ", $message)[1];     //to logout
        $message = explode(". ", $message)[0];  //The message of error
    }
    

?>

<img class='img-404' src="https://img.freepik.com/vector-gratis/concepto-fallo-tecnico-landing-page_52683-12188.jpg" alt="ERRO 404">
<div class='code'>
    <div class='title-error'>
        <i class="fi fi-sr-triangle-warning"></i>
        <h2>Oops! Pagina no encontrada.</h2>
    </div>
</div>
<hr>
<div class="content">
    <h2><?= h($message) ?>. <?= $this->Html->link(__('Volver'), $back) ?></h2>
    <p class="error">
        <strong><?= __d('cake', 'Error') ?>: </strong>
        <?= __d('cake', 'The requested address {0} was not found on this server.', "<strong>'{$url}'</strong>") ?>
    </p>
</div>
