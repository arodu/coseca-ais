<?php
declare(strict_types=1);

namespace FilterTenant\Test\TestCase\Model\Behavior;

use Cake\ORM\Table;
use Cake\TestSuite\TestCase;
use FilterTenant\Model\Behavior\FilterTenantBehavior;

/**
 * FilterTenant\Model\Behavior\FilterTenantBehavior Test Case
 */
class FilterTenantBehaviorTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \FilterTenant\Model\Behavior\FilterTenantBehavior
     */
    protected $FilterTenant;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $table = new Table();
        $this->FilterTenant = new FilterTenantBehavior($table);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->FilterTenant);

        parent::tearDown();
    }
}
