<?php

/**
 * @var \App\View\AppView $this
 */
?>

<?php foreach ($projects as $project) : ?>
    <div class="col-12">
        <h5><?= h($project->label_name) ?></h5>
    </div>
    <table class="table table-sm table-hover">
        <thead>
            <tr>
                <th><?= __('no') ?></th>
                <th><?= __('cedula') ?></th>
                <th><?= __('nombre') ?></th>
                <th><?= __('apellido') ?></th>
                <th><?= __('principal') ?></th>
                <th><?= __('etapa') ?></th>
                <th><?= __('tutor academico') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1 ?>
            <?php foreach ($studentAdscriptions[$project->id] as $adscription) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= h($adscription->student->dni) ?></td>
                    <td><?= h($adscription->student->first_name) ?></td>
                    <td><?= h($adscription->student->last_name) ?></td>
                    <td><?= $this->App->yn($adscription->principal) ?></td>
                    <td>
                        <?= __('{0} - {1}', h($adscription->student->last_stage->stage_label), h($adscription->student->last_stage->status_label)) ?>
                    </td>
                    <td><?= h($adscription->tutor->name) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br />
<?php endforeach; ?>