<div class="card">
    <div class="card-header border-0">
        <h3 class="card-title"><?= __('Cantidad de estudiantes por Etapa / Estatus') ?></h3>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><?= __('Etapa / Estatus') ?></th>
                    <?php foreach ($statuses as $status) : ?>
                        <th><?= $this->App->badge($status) ?></th>
                    <?php endforeach; ?>
                    <th><?= $this->Html->tag('span', __('Total'), ['class' => 'badge badge-dark']) ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stages as $stage) : ?>
                    <tr>
                        <th><?= $stage->label() ?></th>
                        <?php $sum = 0 ?>
                        <?php foreach ($statuses as $status) : ?>
                            <td><?= $reports[$stage->value][$status->value] ?? 0 ?></td>
                            <?php $sum += $reports[$stage->value][$status->value] ?? 0 ?>
                        <?php endforeach; ?>
                        <td><?= $sum ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>