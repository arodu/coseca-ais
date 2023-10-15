<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box bg-info">
        <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
        <div class="info-box-content">
            <span class="info-box-text"><?= __('Lapsos Activos') ?></span>
            <span class="info-box-number"><?= implode(', ', $currentLapses) ?></span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
<!-- /.col -->
<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box bg-warning">
        <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>
        <div class="info-box-content">
            <span class="info-box-text"><?= __('Estudiantes Activos') ?></span>
            <span class="info-box-number"><?= __('{0} / {1}', 0, $studentsActives) ?></span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
<!-- /.col -->
<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box bg-danger">
        <span class="info-box-icon"><i class="fas fa-comments"></i></span>
        <div class="info-box-content">
            <span class="info-box-text"><?= __('Proyectos Activos') ?></span>
            <span class="info-box-number">N/A</span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
<!-- /.col -->
<div class="col-md-3 col-sm-6 col-12">
    <div class="info-box bg-success">
        <span class="info-box-icon"><i class="far fa-thumbs-up"></i></span>
        <div class="info-box-content">
            <span class="info-box-text"><?= __('Horas Completadas') ?></span>
            <span class="info-box-number">N/A</span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
<!-- /.col -->

<?php


//debug();

?>