<?php
declare(strict_types=1);

namespace App\Loader;

use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Cake\Http\MiddlewareQueue;
use CakeDC\Users\Loader\MiddlewareQueueLoader;
use ModalForm\Middleware\ModalFormMiddleware;
use Muffin\Footprint\Middleware\FootprintMiddleware;

class AppMiddlewareQueueLoader extends MiddlewareQueueLoader
{
    /**
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue
     * @param \Authentication\AuthenticationServiceProviderInterface $authenticationServiceProvider
     * @return void
     */
    protected function loadAuthenticationMiddleware(
        MiddlewareQueue $middlewareQueue,
        AuthenticationServiceProviderInterface $authenticationServiceProvider
    ): void {
        $authentication = new AuthenticationMiddleware($authenticationServiceProvider);
        $middlewareQueue->add($authentication);
        $middlewareQueue->add(FootprintMiddleware::class);
        $middlewareQueue->add(ModalFormMiddleware::class);
    }
}
