<!-- Sidebar user panel (optional) -->
<?= $this->element('CakeLte.sidebar/user') ?>
<?= $this->element('CakeLte.sidebar/search') ?>

<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column <?= $this->CakeLte->getMenuClass() ?>" data-widget="treeview" role="menu" data-accordion="false">
        <?php echo $this->element('CakeLte.sidebar/menu') ?>
    </ul>

    <div class="mt-5 text-center text-light">
        <?= $this->element('current_commit') ?>
    </div>
</nav>
