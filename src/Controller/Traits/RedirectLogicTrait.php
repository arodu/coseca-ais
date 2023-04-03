<?php

declare(strict_types=1);

namespace App\Controller\Traits;

use Cake\Http\Response;

trait RedirectLogicTrait
{
    protected string $redirectKey = 'redirect';

    public function redirect($url, int $status = 302): ?Response
    {
        if ($redirect = $this->getRedirectUrl()) {
            $url = $redirect;
        }

        return parent::redirect($url, $status);
    }

    public function getRedirectUrl(): ?string
    {
        return $this->getRequest()->getQuery($this->redirectKey)
            ?? $this->getRequest()->getData($this->redirectKey)
            ?? null;
    }
}
