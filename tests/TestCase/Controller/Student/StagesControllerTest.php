<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Student;

use App\Controller\Student\StagesController;
use App\Model\Field\UserRole;
use App\Test\Factory\AppUserFactory;
use App\Test\Factory\ProgramFactory;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Student\StagesController Test Case
 *
 * @uses \App\Controller\Student\StagesController
 */
class StagesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\Student\StagesController::index()
     */
    public function testIndex(): void
    {
        $user = AppUserFactory::make()
            ->withRole(UserRole::STUDENT)
            ->withTenant()
            ->persist();

        dd($user);

        //'TenantFilters',
        //'CurrentStudent' => ['Tenants'],


    }
}
