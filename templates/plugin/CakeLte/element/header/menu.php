<?php

use App\Model\Field\UserRole;
use Cake\Core\Configure;

?>

<li class="nav-item d-none d-sm-inline-block">
  <?= $this->Html->link(__('Home'), '/', ['class' => 'nav-link']) ?>
</li>

<?php if ($this->Identity->get('role') === UserRole::ROOT->value) : ?>
  <li class="nav-item d-none d-sm-inline-block">
    <?= $this->Html->link(__('Admin'), ['_name' => 'admin:home'], ['class' => 'nav-link']) ?>
  </li>
  <li class="nav-item d-none d-sm-inline-block">
    <?= $this->Html->link(__('Manager'), ['_name' => 'manager:home'], ['class' => 'nav-link']) ?>
  </li>
<?php endif; ?>

<?php if (Configure::read('debug')) : ?>
  <li class="nav-item d-none d-sm-inline-block">
    <?= $this->Html->link(__('Debug'), '/cake_lte/debug', ['class' => 'nav-link']) ?>
  </li>

  <li class="nav-item d-none d-sm-inline-block">
    <?= $this->Html->link(__('Theme'), '/adminlte/index.html', ['class' => 'nav-link']) ?>
  </li>
<?php endif; ?>