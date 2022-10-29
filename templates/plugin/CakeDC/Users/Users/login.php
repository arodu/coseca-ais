<?php

/**
 * @var \App\View\AppView $this
 */

$this->layout = 'CakeLte.login';
?>

<div class="card">
    <div class="card-body login-card-body">
        <?= $this->Flash->render('auth') ?>
        <?= $this->Form->create() ?>
        <?= $this->Form->control('username', [
            'label' => false,
            'placeholder' => __('Email'),
            'append' => '<i class="fas fa-user"></i>',
        ]) ?>

        <?= $this->Form->control('password', [
            'label' => false,
            'placeholder' => __('Contraseña'),
            'append' => '<i class="fas fa-lock"></i>',
        ]) ?>

        <div class="row">
            <div class="col-8">
                <?= $this->Form->control('remember_me', ['label' => __('Recordarme'), 'type' => 'checkbox', 'custom' => true]) ?>
            </div>
            <div class="col-4">
                <?= $this->Form->control(__('Inicio'), ['type' => 'submit', 'class' => 'btn btn-primary btn-block']) ?>
            </div>
        </div>

        <?= $this->Form->end() ?>

        <!--
        <div class="social-auth-links text-center mb-3">
            <p>- OR -</p>
            <?= $this->Html->link(
                '<i class="fab fa-facebook-f mr-2"></i>' . __('Facebook'),
                '#',
                ['class' => 'btn btn-block btn-primary', 'escape' => false]
            ) ?>
            <?= $this->Html->link(
                '<i class="fab fa-google mr-2"></i>' . __('Google'),
                '#',
                ['class' => 'btn btn-block btn-danger', 'escape' => false]
            ) ?>
        </div>
            -->
        <?= implode(' ', $this->User->socialLoginList()); ?>
        <!-- /.social-auth-links -->

        <p class="mb-1">
            <?= $this->Html->link(__('I forgot my password'), ['action' => 'requestResetPassword']) ?>
        </p>
        <p class="mb-0">
            <?= $this->Html->link(__('Register a new membership'), ['action' => 'register']) ?>
        </p>
    </div>
    <!-- /.login-card-body -->
</div>
