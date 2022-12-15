<?php

declare(strict_types=1);

namespace ModalForm\Validator;

interface ValidatorInterface
{
    public function isValid(): bool;
    
}
