<?php
declare(strict_types=1);

namespace FilterTenant\Test\TestCase\Middleware;

use Cake\TestSuite\TestCase;
use FilterTenant\Middleware\FilterTenantMiddleware;

/**
 * FilterTenant\Middleware\FilterTenantMiddleware Test Case
 */
class FilterTenantMiddlewareTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \FilterTenant\Middleware\FilterTenantMiddleware
     */
    protected $FilterTenant;

    /**
     * Test process method
     *
     * @return void
     * @uses \FilterTenant\Middleware\FilterTenantMiddleware::process()
     */
    public function testProcess(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
