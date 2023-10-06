<?php

/**
 * @var \App\View\AppView $this
 */
?>
<?php
$label = __('{0} - {1}, {2}', $tenant->program->name, $tenant->name, $lapse->name);

$this->assign('title', $label);
$this->Breadcrumbs->add([
    ['title' => __('Inicio'), 'url' => ['action' => 'dashboard']],
    ['title' => $label],
]);
?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>
                    <?= __('Reportes') ?>
                </h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <?= $this->Html->link(__('General'), '#general', ['class' => 'nav-link active', 'data-toggle' => 'tab']) ?>
                        </li>
                        <li class="nav-item">
                            <?= $this->Html->link(__('Proyectos'), '#projects', ['class' => 'nav-link', 'data-toggle' => 'tab']) ?>
                        </li>
                        <li class="nav-item">
                            <?= $this->Html->link(__('Tutores'), '#tutors', ['class' => 'nav-link', 'data-toggle' => 'tab']) ?>
                        </li>
                        <li class="nav-item">
                            <?= $this->Html->link(__('Aprobados'), '#approved', ['class' => 'nav-link', 'data-toggle' => 'tab']) ?>
                        </li>
                    </ul>
                </div>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="chart tab-pane active" id="general">
                        <?= $this->element('Reports/general', compact('approvedCourse')) ?>
                    </div>
                    <div class="chart tab-pane" id="projects">
                        <?= $this->element('Reports/projects', compact('projects', 'studentAdscriptions')) ?>
                    </div>
                    <div class="chart tab-pane" id="tutors">
                        tutors
                    </div>
                    <div class="chart tab-pane table-responsive" id="approved">
                        <?= $this->element('Reports/approved', compact('approvedService')) ?>
                    </div>
                </div>
            </div><!-- /.card-body -->
        </div>

    </div>
</div>