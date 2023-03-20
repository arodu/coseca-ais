<?php

/**
 * @var \App\View\AppView $this
 * @var \CakeDC\Users\Model\Entity\User $user
 */

$this->layout = 'CakeLte.login';
?>

<div class="card">
    <div class="card-body register-card-body">
        <p class="login-box-msg"><?= __('¿Olvidaste tu contraseña? Aquí puedes recuperar fácilmente una nueva.') ?></p>
        <?= $this->Flash->render('auth') ?>
        <?= $this->Form->create($user) ?>
        <?= $this->Form->control('reference', [
            'type' => 'email',
            'placeholder' => __('Email'),
            'label' => false,
            'append' => '<i class="fas fa-envelope"></i>',
        ]) ?>

        <div class="row">
            <div class="col-4 offset-8">
                <?= $this->Form->control(__('Enviar'), [
                    'type' => 'submit',
                    'class' => 'btn btn-primary btn-block',
                ]) ?>
            </div>
        </div>

        <?= $this->Form->end() ?>
        <!-- /.social-auth-links -->

        <p class="mb-1 mt-3">
            <?= $this->Html->link(__('Inicio de sesión'), ['action' => 'login']) ?>
        </p>
        <p class="mb-0">
            <?= $this->Html->link(__('Registrar un nuevo estudiante'), ['action' => 'register']) ?>
        </p>
    </div>
    <!-- /.register-card-body -->
</div>
