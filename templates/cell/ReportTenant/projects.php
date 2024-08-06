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
                <th scope="col"><?= __('Nº') ?></th>
                <th scope="col"><?= __('Cédula') ?></th>
                <th scope="col"><?= __('Nombre') ?></th>
                <th scope="col"><?= __('Apellido') ?></th>
                <th scope="col"><?= __('Principal') ?></th>
                <th scope="col"><?= __('Etapa') ?></th>
                <th scope="col"><?= __('Tutor Académico') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1 ?>
            <?php foreach ($studentAdscriptions[$project->id] as $adscription) : ?>
                <tr class="table-light">
                    <td><?= $no++ ?></td>
                    <td class="col-lg-2"><?= h($adscription->student->dni) ?></td>
                    <td class="col-lg-2"><?= h($adscription->student->first_name) ?></td>
                    <td class="col-lg-2"><?= h($adscription->student->last_name) ?></td>
                    <td class="col-lg-2"><?= $this->App->yn($adscription->principal) ?></td>
                    <td class="col-lg-2">
                        <?= __('{0} - {1}', h($adscription->student->last_stage->stage_label), h($adscription->student->last_stage->status_label)) ?>
                    </td>
                    <td class="col-lg-2"><?= h($adscription->tutor->name) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br />
<?php endforeach; ?>