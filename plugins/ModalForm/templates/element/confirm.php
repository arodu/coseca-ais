<?php

use ModalForm\ModalFormPlugin;

$this->extend($modalTemplate);

$this->assign('modal-target', $target);
$this->assign('modal-title', $title);
?>

<div class="alert alert-light message"></div>

<?= $this->Form->hidden('modalForm.confirm', ['value' => ModalFormPlugin::VALIDATOR_CONFIRM]) ?>

<?php $this->start('modal-footer') ?>
<?= $this->Form->button(__('Yes'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->button(__('No'), ['data-dismiss' => 'modal', 'type' => 'button']) ?>
<?php $this->end(); ?>