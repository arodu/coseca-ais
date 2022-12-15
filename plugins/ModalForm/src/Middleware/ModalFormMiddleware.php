<?php

declare(strict_types=1);

namespace ModalForm\Middleware;

use Cake\Http\ServerRequest;
use ModalForm\Validator\CheckboxValidator;
use ModalForm\Validator\PasswordValidator;
use ModalForm\Validator\ValidatorInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * ModalForm middleware
 */
class ModalFormMiddleware implements MiddlewareInterface
{

    protected $_validators = [
        'password' => PasswordValidator::class,
        'checkbox' => CheckboxValidator::class,
    ];

    /**
     * Process method.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param \Psr\Http\Server\RequestHandlerInterface $handler The request handler.
     * @return \Psr\Http\Message\ResponseInterface A response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $modalFormData = $request->getData('modalForm') ?? $request->getQuery('modalForm') ?? null;

        if (!empty($modalFormData)) {
            $request = $request
                ->withAttribute('modalForm', $this->loadValidator($request, $modalFormData))
                ->withoutData('modalForm');
        }

        return $handler->handle($request);
    }

    protected function loadValidator(ServerRequest $request, array $modalFormData = []): ValidatorInterface
    {

        
        return new CheckboxValidator($request, $modalFormData);
    }
}
