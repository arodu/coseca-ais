<?php

/**
 * @var \App\View\AppView $this
 */
?>

<div class="row">
    <div class="col-md-5 col-xl-3">
        <?= $this->cell('StudentInfo', ['student_id' => $this->student_id]) ?>
    </div>
    <!-- /.col -->
    <div class="col-md-7 col-xl-9">
        <div class="card card-light card-tabs">
            <div class="card-header p-0 pt-1">
                <?= $this->cell('StudentInfo::menu', ['student_id' => $this->student_id, 'activeItem' => $this->active]) ?>
            </div>
            <?= $this->fetch('content') ?>
        </div>
        <!-- /.card -->
        <?= $this->fetch('appendContent') ?>
    </div>
    <!-- /.col -->
</div>