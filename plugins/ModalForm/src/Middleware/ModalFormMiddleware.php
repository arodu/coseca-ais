<?php

declare(strict_types=1);

namespace ModalForm\Middleware;

use Cake\Http\ServerRequest;
use ModalForm\ModalFormPlugin;
use ModalForm\Validator\CheckboxValidator;
use ModalForm\Validator\ConfirmValidator;
use ModalForm\Validator\PasswordValidator;
use ModalForm\Validator\TextInputValidator;
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
        ModalFormPlugin::VALIDATOR_PASSWORD => PasswordValidator::class,
        ModalFormPlugin::VALIDATOR_CHECKBOX => CheckboxValidator::class,
        ModalFormPlugin::VALIDATOR_CONFIRM => ConfirmValidator::class,
        ModalFormPlugin::VALIDATOR_TEXT_INPUT => TextInputValidator::class,
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
        $validator = $this->_validators[$modalFormData['validator']] ?? null;

        if (empty($validator)) {
            // @todo custom exception
            throw new \Cake\Http\Exception\NotFoundException();
        }
        
        return new $validator($request, $modalFormData);
    }
}
