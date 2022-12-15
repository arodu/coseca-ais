<?php

use Cake\Utility\Text;
use ModalForm\ModalFormPlugin;

$this->extend($modalTemplate);

$this->assign('modal-target', $target);
$this->assign('modal-title', $title);

$label = Text::insert($content['textTemplate'], [
    'confirm' => $content['confirm']
]);
?>

<div class="alert alert-light message"></div>

<?= $this->Form->hidden('modalForm.validator', ['value' => ModalFormPlugin::VALIDATOR_TEXT_INPUT]) ?>
<?= $this->Form->hidden('modalForm.confirm', ['value' => $content['confirm']]) ?>

<?= $this->Form->control('modalForm.input', [
    'label' => $label,
    'required' => true,
    'escape' => false,
]) ?>
