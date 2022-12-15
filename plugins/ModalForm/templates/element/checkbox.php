<?php

use ModalForm\ModalFormPlugin;

$this->extend($modalTemplate);

$this->assign('modal-target', $target);
$this->assign('modal-title', $title);
?>

<div class="alert alert-light message"></div>

<?= $this->Form->hidden('modalForm.validator', ['value' => ModalFormPlugin::VALIDATOR_CHECKBOX]) ?>
<?= $this->Form->control('modalForm.confirm', [
    'type' => 'checkbox',
    'label' => __('Check this to confirm'),
    'required' => true,
]) ?>
