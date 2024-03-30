<?php

/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $user
 * @var \App\Model\Entity\AppUser $user
 */

use App\Model\Field\UserRole;

?>

<?php
$this->assign('title', __('User'));
$this->assign('backUrl', $redirect ?? $this->Url->build(['action' => 'index']));
$this->Breadcrumbs->add([
    ['title' => __('Home'), 'url' => '/'],
    ['title' => __('List Users'), 'url' => ['action' => 'index']],
    ['title' => __('View')],
]);
?>

<div class="view card card-primary card-outline">
    <div class="card-header d-sm-flex">
        <h2 class="card-title"><?= h($user->full_name) ?></h2>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <tr>
                <th><?= __('Email') ?></th>
                <td><?= h($user->email) ?></td>
            </tr>
            <tr>
                <th><?= __('Dni') ?></th>
                <td><?= h($user->dni) ?></td>
            </tr>
            <tr>
                <th><?= __('First Name') ?></th>
                <td><?= h($user->first_name) ?></td>
            </tr>
            <tr>
                <th><?= __('Last Name') ?></th>
                <td><?= h($user->last_name) ?></td>
            </tr>
            <tr>
                <th><?= __('Role') ?></th>
                <td><?= h($user->enum('role')->label()) ?></td>
            </tr>
            <tr>
                <th><?= __('Created') ?></th>
                <td><?= h($user->created) ?></td>
            </tr>
            <tr>
                <th><?= __('Modified') ?></th>
                <td><?= h($user->modified) ?></td>
            </tr>
            <tr>
                <th><?= __('Last Login') ?></th>
                <td><?= h($user->last_login) ?></td>
            </tr>
            <tr>
                <th><?= __('Active') ?></th>
                <td><?= $user->active ? __('Yes') : __('No'); ?></td>
            </tr>
        </table>
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
            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id], ['class' => 'btn btn-secondary']) ?>
            <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>

<?php if ($user->enum('role')->isGroup(UserRole::GROUP_STUDENT)) : ?>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Estudiante</h3>
        </div>
        <div class="card-body">
            <p>Estudiante</p>
        </div>
    </div>
<?php endif; ?>

<?php if ($user->enum('role')->isGroup(UserRole::GROUP_STAFF)) : ?>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Staff</h3>
        </div>
        <div class="card-body">
            <p>Staff</p>
        </div>
    </div>
<?php endif; ?>