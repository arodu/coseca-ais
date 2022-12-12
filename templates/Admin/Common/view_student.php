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
        <div class="card">
            <div class="card-header p-2">
                <?= $this->element('admin/student_menu', ['active' => $this->active, 'student_id' => $this->student_id]) ?>
            </div><!-- /.card-header -->
            <?= $this->fetch('content') ?>
        </div>
        <!-- /.card -->
        <?= $this->fetch('appendContent') ?>
    </div>
    <!-- /.col -->
</div>
