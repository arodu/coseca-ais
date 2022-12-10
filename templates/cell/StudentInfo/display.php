<!-- Profile Image -->
<div class="card card-primary card-outline">
    <div class="card-body box-profile">
        <h3 class="profile-username text-center"><?= $student->full_name ?></h3>

        <p class="text-muted text-center"><?= h($student->dni) ?></p>


        <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
                <b>Programa</b>
                <a class="float-right"><?= h($student->tenant->name) ?></a>
            </li>
            <li class="list-group-item">
                <b><?= __('Tipo') ?></b>
                <a class="float-right"><?= $student->getType()->label() ?></a>
            </li>
            <li class="list-group-item">
                <b>email</b>
                <a class="float-right"><?= $student->app_user->email ?></a>
            </li>
        </ul>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?= __('Etapa Actual') ?></h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
                <b>Nombre</b>
                <a class="float-right"><?= h($student->last_stage->stage_label) ?></a>
            </li>
            <li class="list-group-item">
                <b><?= __('Lapso Académico') ?></b>
                <a class="float-right"><?= $student->last_stage->lapse->name ?></a>
            </li>
            <li class="list-group-item">
                <b>Estado</b>
                <a class="float-right">
                    <?= $this->Html->tag(
                        'span',
                        $student->last_stage->status_label,
                        ['class' => [$student->last_stage->getStatus()->color()->cssClass('badge'), 'ml-2']]
                    ) ?>
                </a>
            </li>
        </ul>
    </div>
</div>