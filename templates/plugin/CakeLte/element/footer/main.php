<?php

use App\Utility\FaIcon;
use Cake\Core\Configure;

$year = date('Y');
?>

<!-- To the right -->
<div class="float-right d-none d-sm-inline">
    <?= $this->Html->link(FaIcon::get('telegram', 'fa-fw fa-lg'), Configure::read('App.socialNetworks.telegram'), ['escape' => false, 'target' => '_blank']) ?>

    <?= $this->Html->link(FaIcon::get('university', 'fa-fw fa-lg'), Configure::read('App.socialNetworks.unerg'), ['escape' => false, 'target' => '_blank']) ?>
</div>
<!-- Default to the left -->
<strong>&copy; 2023<?= $year > 2023 ? ' - ' . $year : '' ?>
