<?php

use CakeLteTools\Utility\FaIcon;

$user = $this->Identity->get();
?>
<div class="user-panel mt-3 pb-3 mb-3 d-flex text-light align-items-center">
    <div class="image">
        <?= FaIcon::get('user', ['class' => 'fa-2x']) ?>
    </div>
    <div class="info">
        <div class="d-block"><?= h($user->full_name) ?></div>
        <div class="d-block"><?= $this->Html->tag('span', $user->getRole()->value, ['class' => 'badge badge-light']) ?></div>
    </div>
</div>