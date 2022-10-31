<?php

/**
 * @var \App\View\AppView $this
 * @var \CakeDC\Users\Model\Entity\User $user
 */

$this->layout = 'CakeLte.login';
?>

<div class="card">
    <div class="card-body change-password-card-body">
        <p class="login-box-msg"><?= __('Please enter the new password.') ?></p>
        <?= $this->Flash->render('auth') ?>
        <?= $this->Form->create($user) ?>

        <?php if ($validatePassword) : ?>
            <?= $this->Form->control('current_password', [
                'type' => 'password',
                'required' => true,
                'label' => false,
                'placeholder' => __d('cake_d_c/users', 'Current password'),
                'append' => '<i class="fas fa-key"></i>',
            ]); ?>
        <?php endif; ?>
        <?= $this->Form->control('password', [
            'type' => 'password',
            'required' => true,
            'label' => false,
            'placeholder' => __d('cake_d_c/users', 'New password'),
            'append' => '<i class="fas fa-key"></i>',
        ]); ?>
        <?= $this->Form->control('password_confirm', [
            'type' => 'password',
            'required' => true,
            'label' => false,
            'placeholder' => __d('cake_d_c/users', 'Confirm password'),
            'append' => '<i class="fas fa-key"></i>',
        ]); ?>

        <div class="row">
            <div class="col-12">
                <?= $this->Form->control(__('Request new password'), [
                    'type' => 'submit',
                    'class' => 'btn btn-primary btn-block',
                ]) ?>
            </div>
        </div>
        <?= $this->Form->end() ?>

        <p class="mb-0 mt-3">
            <?= $this->Html->link(__('Login'), ['action' => 'login']) ?>
        </p>
    </div>
    <!-- /change-password-card-body -->
</div>
