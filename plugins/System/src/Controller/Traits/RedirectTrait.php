<?php

declare(strict_types=1);

namespace System\Controller\Traits;

use Cake\Http\Response;

trait RedirectTrait
{
    /**
     * Redirects to given $url, after turning off $this->autoRender.
     *
     * @param \Psr\Http\Message\UriInterface|array|string $url A string, array-based URL or UriInterface instance.
     * @param int $status HTTP status code. Defaults to `302`.
     * @return \Cake\Http\Response|null
     * @link https://book.cakephp.org/4/en/controllers.html#Controller::redirect
     */
    public function redirect($url, int $status = 302): ?Response
    {
        return parent::redirect($this->getRedirectUrl() ?? $url, $status);
    }

    /**
     * @return string|null
     */
    protected function getRedirectUrl(): ?string
    {
        return $this->getRequest()->getQuery('redirect') ?? $this->getRequest()->getData('redirect') ?? null;
    }
}
