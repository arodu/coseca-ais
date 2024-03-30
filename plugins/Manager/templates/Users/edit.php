<?php

/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $user
 */

use App\Model\Field\UserRole;
$currentUser = $this->Identity->get();
?>
<?php
$this->assign('title', __('Edit User'));
$this->assign('backUrl', $redirect ?? $this->Url->build(['action' => 'view', $user->id]));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Users'), 'url' => ['action' => 'index']],
    ['title' => __('View'), 'url' => ['action' => 'view', $user->id]],
    ['title' => __('Edit')],
]);
?>

<div class="card card-primary card-outline">
    <?= $this->Form->create($user) ?>
    <div class="card-body">
        <?php
        echo $this->Form->control('dni', ['label' => 'Cedula']);
        echo $this->Form->control('first_name', ['label' => 'Primer Nombre']);
        echo $this->Form->control('last_name', ['label' => 'Primer Apellido']);
        echo $this->Form->control('email', ['label' => 'Email']);
        echo $this->Form->control('role', [
            'label' => 'Role',
            'options' => UserRole::newUserList($currentUser->enum('role')),
            'empty' => true,
            'required' => true,
        ]);
        echo $this->Form->control('active', ['custom' => true, 'checked' => true]);
        ?>
    </div>

    <div class="card-footer d-flex">
        <div class="">
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $user->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'btn btn-danger']
            ) ?>
        </div>
        <div class="ml-auto">
            <?= $this->Form->button(__('Save')) ?>
            <?= $this->Html->link(__('Cancel'), ['action' => 'view', $user->id], ['class' => 'btn btn-default']) ?>

        </div>
    </div>

    <?= $this->Form->end() ?>
</div>