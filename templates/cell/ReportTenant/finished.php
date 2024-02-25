<table class="table">
    <thead>
        <tr>
            <th><?= __('no') ?></th>
            <th><?= __('cedula') ?></th>
            <th><?= __('nombre') ?></th>
            <th><?= __('apellido') ?></th>
            <th><?= __('nombre proyecto') ?></th>
            <th><?= __('estatus') ?></th>
            <th><?= __('tutor academico') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1 ?>
        <?php foreach ($approvedService as $studentStage) : ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= h($studentStage->student->dni) ?></td>
                <td><?= h($studentStage->student->first_name) ?></td>
                <td><?= h($studentStage->student->last_name) ?></td>
                <td>
                    <?= h($studentStage->student->principal_adscription->institution_project->label_name) ?>
                </td>
                <td><?= $this->App->badge($studentStage->enum('status')) ?></td>
                <td><?= h($studentStage->student->principal_adscription->tutor->name) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>