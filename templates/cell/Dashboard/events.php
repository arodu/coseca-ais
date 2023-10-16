<div class="card">
    <div class="card-header border-0">
        <h3 class="card-title"><?= __('Proximos eventos') ?></h3>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover table-valign-middle">
            <thead>
                <tr>
                    <th><?= __('Area / Programa / Sede') ?></th>
                    <th><?= __('Etapa') ?></th>
                    <th><?= __('Fecha') ?></th>
                    <th><?= __('Estado') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event) : ?>
                    <tr>
                        <td><?= $this->App->tenant($event->lapse->tenant) ?></td>
                        <td><?= h($event->title) ?></td>
                        <td><?= h($event->show_dates) ?></td>
                        <td><code><?= $event->status?->label() ?? __('N/A') ?></code></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>