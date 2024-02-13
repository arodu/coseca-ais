<ul class="nav nav-pills ml-auto">
    <?php foreach ($tabs as $key => $tab) : ?>
        <li class="nav-item">
            <?= $this->Html->link(
                $tab['label'],
                $tab['url'] ?? [
                    'action' => 'tenant',
                    $tenant->id,
                    '?' => ['tab' => $key, 'lapse_id' => $lapseSelected->id],
                ],
                [
                    'class' => 'nav-link' . ($currentTab === $key ? ' active' : ''),
                ]
            ) ?>
        </li>
    <?php endforeach; ?>
</ul>