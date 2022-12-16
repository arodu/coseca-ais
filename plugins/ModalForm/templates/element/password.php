<?php

use ModalForm\ModalFormPlugin;

?>

<div class="modal fade" id="<?= $target ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php if ($content['title'] ?? false) : ?>
                <div class="modal-header">
                    <h5 class="modal-title"><?= $content['title'] ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            <?= $this->Form->create(null, ['url' => '#', 'type' => 'POST']) ?>
            <div class="modal-body">
                <p class="message"></p>
                <?= $this->Form->hidden('modalForm.validator', ['value' => ModalFormPlugin::VALIDATOR_PASSWORD]) ?>
                <?= $this->Form->control('modalForm.password', [
                    'label' => __('Type your password to confirm'),
                    'type' => 'password',
                    'required' => true,
                ]) ?>
            </div>
            <div class="modal-footer">
                <?= $this->Form->button($content['buttonOk'] ?? __('Submit'), ['class' => 'btn btn-primary']) ?>
                <?= $this->Form->button($content['buttonCancel'] ?? __('Close'), ['data-dismiss' => 'modal', 'type' => 'button']) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>