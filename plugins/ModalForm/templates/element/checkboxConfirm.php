<div class="modal-body">

    <div class="alert alert-light message"></div>

    <?= $this->Form->hidden('modalForm.type', ['value' => 'checkbox-confirm']) ?>
    <?= $this->Form->control('modalForm.confirm', [
        'type' => 'checkbox',
        'label' => __('Checked this to confirm'),
        //'required' => true,
    ]) ?>
</div>
<div class="modal-footer">
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->button(__('Close'), ['data-dismiss' => 'modal', 'type' => 'button']) ?>
</div>