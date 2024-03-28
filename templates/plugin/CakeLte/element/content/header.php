<?php

/**
 * @var \App\View\AppView $this
 */
?>

<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0">
            <?php if ($this->fetch('backUrl')) : ?>
                <?= $this->Html->link(
                    '<i class="fas fa-chevron-circle-left fa-fw"></i>',
                    $this->fetch('backUrl'),
                    [
                        'escape' => false,
                        'class' => 'text-secondary',
                    ]
                ) ?>
            <?php endif; ?>
            <?= $this->fetch('title') ?>
        </h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <?= $this->Breadcrumbs->render(['class' => 'float-sm-right']) ?>
    </div><!-- /.col -->
</div><!-- /.row -->