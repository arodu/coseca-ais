<?php

use ModalForm\ModalFormPlugin;

$this->extend($modalTemplate);

$this->assign('modal-target', $target);
$this->assign('modal-title', $title);
?>

<div class="alert alert-light message"></div>

<?= $this->Form->hidden('modalForm.validator', ['value' => ModalFormPlugin::VALIDATOR_PASSWORD]) ?>
<?= $this->Form->control('modalForm.password', [
    'label' => __('Type your password to confirm'),
    'type' => 'password',
    'required' => true,
]) ?>
