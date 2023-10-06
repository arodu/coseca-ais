<?php

/**
 * @var \App\View\AppView $this
 */
?>
<?php
$this->assign('title', __('Inicio'));
$this->Breadcrumbs->add([
    ['title' => __('Inicio')],
]);
?>

<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">CPU Traffic</span>
                <span class="info-box-number">
                    10
                    <small>%</small>
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Likes</span>
                <span class="info-box-number">41,410</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix hidden-md-up"></div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Sales</span>
                <span class="info-box-number">760</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">New Members</span>
                <span class="info-box-number">2,000</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title"><?= __('Sedes Activas') ?></h3>
                <div class="card-tools">
                    <!--
                    <a href="#" class="btn btn-tool btn-sm">
                        <i class="fas fa-download"></i>
                    </a>
                    <a href="#" class="btn btn-tool btn-sm">
                        <i class="fas fa-bars"></i>
                    </a>
                    -->
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                    <thead>
                        <tr>
                            <th><?= __('Area') ?></th>
                            <th><?= __('Programa') ?></th>
                            <th><?= __('Sede') ?></th>
                            <th><?= __('Lapso actual') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($activeTenants as $tenant) : ?>
                            <tr>
                                <td><?= h($tenant->program->area_label) ?></td>
                                <td><?= $this->Html->link($tenant->program->name, ['action' => 'viewProgram', $tenant->program_id], ['class' => '', 'escape' => false]) ?></td>
                                <td><?= $this->Html->link($tenant->name, ['action' => 'view', $tenant->id], ['class' => '', 'escape' => false]) ?></td>
                                <td><?= $this->App->lapseLabel($tenant->current_lapse) ?? $this->App->error(__('Programa debe tener al menos un lapso activo')) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title"><?= __('Actualizaciones') ?></h3>

            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title"><?= __('Estadisticas San Juan, 2023-1') ?></h3>
            </div>
            <div class="card-body">
                <?= __('Cantidad Estudiantes que aprobaron el curso {0}', $cursoAprovado->count()); ?>
            </div>
            <div class="card-body table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th><?= __('no') ?></th>
                            <th><?= __('cedula') ?></th>
                            <th><?= __('nombre') ?></th>
                            <th><?= __('apellido') ?></th>
                            <th><?= __('nombre proyecto') ?></th>
                            <th><?= __('tutor academico') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1 ?>
                        <?php foreach ($servicioAprovado as $studentStage) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= h($studentStage->student->dni) ?></td>
                                <td><?= h($studentStage->student->first_name) ?></td>
                                <td><?= h($studentStage->student->last_name) ?></td>
                                <td>
                                    <?= h($studentStage->student->principal_adscription->institution_project->label_name) ?>
                                </td>
                                <td><?= h($studentStage->student->principal_adscription->tutor->name) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<?php //debug($servicioAprovado->toArray())
?>