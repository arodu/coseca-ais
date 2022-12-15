<div class="modal fade" id="<?= $this->fetch('modal-target') ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= $this->fetch('modal-title') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= $this->Form->create(null, ['url' => '#', 'type' => 'POST']) ?>
            <div class="modal-body">
                <?php if ($this->fetch('message')) : ?>
                    <div class="alert alert-light message">
                        <?= $this->fetch('message') ?>
                    </div>
                <?php endif; ?>
                <?= $this->fetch('content') ?>
            </div>
            <?php if ($this->fetch('modal-footer')) : ?>
                <div class="modal-footer">
                    <?= $this->fetch('modal-footer') ?>
                </div>
            <?php endif; ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>