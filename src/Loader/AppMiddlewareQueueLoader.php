<?php

declare(strict_types=1);

namespace App\Loader;

use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Cake\Http\MiddlewareQueue;
use CakeDC\Users\Loader\MiddlewareQueueLoader;
use FilterTenant\Middleware\FilterTenantMiddleware;
use ModalForm\Middleware\ModalFormMiddleware;
use Muffin\Footprint\Middleware\FootprintMiddleware;

class AppMiddlewareQueueLoader extends MiddlewareQueueLoader
{
    protected function loadAuthenticationMiddleware(
        MiddlewareQueue $middlewareQueue,
        AuthenticationServiceProviderInterface $authenticationServiceProvider
    ) {
        $authentication = new AuthenticationMiddleware($authenticationServiceProvider);
        $middlewareQueue->add($authentication);
        $middlewareQueue->add(FootprintMiddleware::class);
        $middlewareQueue->add(ModalFormMiddleware::class);
        $middlewareQueue->add(FilterTenantMiddleware::class);
    }
}
