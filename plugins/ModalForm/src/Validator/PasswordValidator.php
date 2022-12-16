<?php

declare(strict_types=1);

namespace ModalForm\Validator;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\Http\ServerRequest;

class PasswordValidator implements ValidatorInterface
{
    protected $request;
    protected $modalForm;

    public function __construct(ServerRequest $request = null, array $modalForm)
    {
        $this->request = $request;
        $this->modalForm = $modalForm;
    }

    public function isValid(): bool
    {
        $user = $this->request->getAttribute('identity')->getOriginalData();

        return (new DefaultPasswordHasher())->check($this->modalForm['password'], $user->password);
    }
}
