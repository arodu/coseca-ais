<?php

/**
 * @var \App\View\AppView $this
 */
?>

<?php if (!$student->active) : ?>
<div class="alert alert-warning">
    <i class="icon fas fa-exclamation-triangle"></i> <?= __('Estudiante Inactivo!') ?>
</div>
<?php endif ?>

<div class="row">
    <div class="col-md-5 col-xl-3">
        <?= $this->cell('StudentInfo', ['student_id' => $student->id]) ?>
    </div>
    <!-- /.col -->
    <div class="col-md-7 col-xl-9">
        <div class="card card-light card-tabs">
            <div class="card-header p-0 pt-1">
                <?= $this->cell('StudentInfo::menu', ['student_id' => $student->id, 'activeItem' => $this->active]) ?>
            </div>
            <?= $this->fetch('content') ?>
        </div>
        <!-- /.card -->
        <?= $this->fetch('appendContent') ?>
    </div>
    <!-- /.col -->
</div>