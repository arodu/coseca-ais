<div class="modal-body">

    <div class="alert alert-light message"></div>

    <?= $this->Form->hidden('modalForm.type', ['value' => 'password-confirm']) ?>
    <?= $this->Form->control('modalForm.password', [
        'type' => 'password',
        'label' => __('Password'),
        'required' => true,
    ]) ?>
</div>
<div class="modal-footer">
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->button(__('Close'), ['data-dismiss' => 'modal', 'type' => 'button']) ?>
</div>