<div class="modal fade" id="<?= $target ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= $this->Form->create(null, ['url' => '#', 'type' => 'POST']) ?>
            <?= $this->element($element) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
