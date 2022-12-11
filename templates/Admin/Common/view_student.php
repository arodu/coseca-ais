<?php

/**
 * @var \App\View\AppView $this
 */
?>

<div class="row">
    <div class="col-md-3">
        <?= $this->cell('StudentInfo', ['student_id' => $this->student_id]) ?>
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="card">
            <div class="card-header p-2">
                <?= $this->element('admin/student_menu', ['active' => $this->active, 'student_id' => $this->student_id]) ?>
            </div><!-- /.card-header -->
            <div class="card-body">
                <?= $this->fetch('content') ?>
            </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>