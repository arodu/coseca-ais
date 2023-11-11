<?php
declare(strict_types=1);

namespace FilterTenant\Middleware;

use FilterTenant\Utility\FilterTenantUtility;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * FilterTenant middleware
 */
class FilterTenantMiddleware implements MiddlewareInterface
{
    /**
     * Process method.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param \Psr\Http\Server\RequestHandlerInterface $handler The request handler.
     * @return \Psr\Http\Message\ResponseInterface A response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $user = $request?->getAttribute('identity')?->getOriginalData() ?? null;

        if (!empty($user)) {
            $filterTenantUtility = new FilterTenantUtility;
            $tenant_ids = $filterTenantUtility->getTenantIds($user);

            if (empty($tenant_ids)) {
                throw new \Exception('No tenant ids found for user');
            }

            FilterTenantUtility::write($tenant_ids);            
        }

        return $handler->handle($request);
    }
}
