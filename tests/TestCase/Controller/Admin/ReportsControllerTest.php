<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Admin\ReportsController Test Case
 *
 * @uses \App\Controller\Admin\ReportsController
 */
class ReportsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Test dashboard method
     *
     * @return void
     * @uses \App\Controller\Admin\ReportsController::dashboard()
     * @skip
     */
    public function testDashboard(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test tenant method
     *
     * @return void
     * @uses \App\Controller\Admin\ReportsController::tenant()
     * @skip
     */
    public function testTenant(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
