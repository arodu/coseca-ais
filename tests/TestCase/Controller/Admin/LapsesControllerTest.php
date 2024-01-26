<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use App\Controller\Admin\LapsesController;
use App\Model\Entity\LapseDate;
use App\Test\Factory\LapseFactory;
use App\Test\Factory\ProgramFactory;
use App\Test\Factory\TenantFactory;
use App\View\Helper\AppHelper;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Admin\LapsesController Test Case
 *
 * @uses \App\Controller\Admin\LapsesController
 */
class LapsesControllerTest extends AdminTestCase
{
    use IntegrationTestTrait;

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\Admin\LapsesController::add()
     */
    public function testAdd(): void
    {
        $this->setAuthSession();

        $program = ProgramFactory::make()->persist();
        $tenant = TenantFactory::make([
            'program_id' => $program->id,
        ])->persist();

        $this->get('/admin/lapses/add/' . $tenant->id);
        $this->assertResponseCode(200);
        $this->assertResponseContains($tenant->name);

        $this->post('/admin/lapses/add/' . $program->id, [
            'name' => 'Test',
        ]);

        $this->assertResponseContains('Test');

        $this->get('/admin/tenants/view/' . $tenant->id);
        $this->assertResponseCode(200);
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\Admin\LapsesController::edit()
     * @skiped
     */
    public function testEdit(): void
    {
        $this->setAuthSession();

        $program = ProgramFactory::make()->persist();
        $tenant = TenantFactory::make([
            'program_id' => $program->id,
        ])->persist();

        $this->get('/admin/tenants/view/' . $tenant->id);
        $this->assertResponseCode(200);

        $lapse = LapseFactory::make([
            'tenant_id' => $tenant->id
        ])->persist();

        $this->get('/admin/lapses/edit/' . $lapse->id);
        $this->assertResponseCode(200);

        $this->post('/admin/lapses/edit/' . $lapse->id, [
            'name' => 'Lapso editado',
        ]);
        $this->assertResponseCode(302);

        $this->get('/admin/tenants/view/' . $tenant->id);
        $this->assertResponseCode(200);
        $this->assertResponseContains('Lapso editado');
        $this->assertResponseNotContains($lapse->name);
    }

    /**
     * Test editDates method
     *
     * @return void
     * @uses \App\Controller\Admin\LapsesController::editDates()
     * @skiped
     */
    // public function testEditDates(): void
    // {
    //     $this->setAuthSession();

    //     $program = ProgramFactory::make()->persist();
    //     $tenant = TenantFactory::make([
    //         'program_id' => $program->id
    //     ])->persist();

    //     $lapse = LapseFactory::make([
    //         'tenant_id' => $tenant->id
    //     ])->persist();

    //     // dd($lapse);

    //     $this->get('/admin/lapses/edit-dates/' . $lapse->id);
    //     $this->assertResponseCode(200);
    // }

    /**
     * Test changeActive method
     *
     * @return void
     * @uses \App\Controller\Admin\LapsesController::changeActive()
     */
    // public function testChangeActive(): void
    // {
    //     $this->setAuthSession();
    //     LapseFactory::make([
    //         'tenant_id' => $this->tenant_id
    //     ])->persist();
    // }
}
