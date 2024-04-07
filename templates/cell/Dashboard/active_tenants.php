<div class="card">
    <div class="card-header border-0">
        <h3 class="card-title"><?= __('Sedes Activas') ?></h3>
        <div class="card-tools">
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover table-valign-middle">
            <thead>
                <tr>
                    <th><?= __('Area / Programa / Sede') ?></th>
                    <th><?= __('Lapso actual') ?></th>
                    <th class="actions"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($activeTenants as $tenant) : ?>
                    <tr>
                        <td><?= $this->App->tenant($tenant) ?></td>
                        <td><?= $this->App->lapseLabel($tenant->current_lapse) ?? $this->App->error(__('Programa debe tener al menos un lapso activo')) ?></td>
                        <td class="actions">
                            <?= $this->Button->statistics([
                                'url' => ['controller' => 'Reports', 'action' => 'tenant', $tenant->id],
                                'icon-link' => true,
                                'data-toggle' => 'tooltip',
                            ]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>