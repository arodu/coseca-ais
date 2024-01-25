<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use App\Controller\Admin\TenantsController;
use App\Model\Entity\InterestArea;
use App\Model\Entity\Program;
use App\Model\Field\ProgramArea;
use App\Model\Field\ProgramRegime;
use App\Test\Factory\InterestAreaFactory;
use App\Test\Factory\LapseFactory;
use App\Test\Factory\ProgramFactory;
use App\Test\Factory\TenantFactory;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Admin\TenantsController Test Case
 *
 * @uses \App\Controller\Admin\TenantsController
 */
class TenantsControllerTest extends AdminTestCase
{
    use IntegrationTestTrait;

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\Admin\TenantsController::index()
     */
    public function testIndex(): void
    {
        $this->get('/admin/tenants');
        $this->assertResponseCode(302);

        $this->setAuthSession();
        $this->get('/admin/tenants');
        $this->assertResponseCode(200);

        $program = ProgramFactory::make()->persist();
        $tenant = TenantFactory::make([
            'program_id' => $program->id,
            'name' => 'San Juan',
            'abbr' => 'SJM',
            'active' => true
        ])->persist();

        $this->get('/admin/tenants');
        $this->assertResponseCode(200);

        $this->assertResponseContains($tenant->name);
        $this->assertResponseContains($tenant->abbr);
        $this->assertEquals(True, $tenant->active);
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\Admin\TenantsController::view()
     */
    public function testView(): void
    {
        $this->setAuthSession();

        $program = ProgramFactory::make()->persist();
        $lapse = LapseFactory::make([
            'tenant_id' => $this->tenant_id
        ])->persist();

        $tenant = TenantFactory::make([
            'program_id' => $program->id
        ])->persist();

        $this->get('/admin/tenants/view/' . $tenant->id);
        $this->assertResponseCode(200);

        $this->assertEquals(True, $lapse->active);

        $this->assertResponseContains($program->name);
        $this->assertResponseContains($program->abbr);
    }

    /**
     * Test viewProgram method
     *
     * @return void
     * @uses \App\Controller\Admin\TenantsController::viewProgram()
     */
    public function testViewProgram(): void
    {
        $this->setAuthSession();

        $program = ProgramFactory::make()->persist();
        $interes_area = InterestAreaFactory::make([
            'program_id' => $program->id
        ])->persist();

        $tenant = TenantFactory::make([
            'program_id' => $program->id
        ])->persist();

        $this->get('/admin/tenants/view-program/' . $program->id);
        $this->assertResponseCode(200);

        // Tenant
        $this->assertResponseContains($tenant->name);
        $this->assertResponseContains($tenant->abbr);
        // Program
        $this->assertResponseContains($program->name);
        $this->assertEquals(True, $program->regime);
        $this->assertEquals(True, $program->abbr);
        // Interest Area
        $this->assertResponseContains($interes_area->name);
        $this->assertEquals(True, $interes_area->active);
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\Admin\TenantsController::add()
     */
    public function testAdd(): void
    {
        $this->setAuthSession();

        $this->get('/admin/tenants/add');
        $this->assertResponseCode(200);

        $program = ProgramFactory::make()->persist();

        $this->post('/admin/tenants/add', [
            'name' => 'Nueva sede test',
            'program_id' => $program->id
        ]);

        $this->assertResponseContains('Nueva sede test');
    }

    /**
     * Test addProgram method
     *
     * @return void
     * @uses \App\Controller\Admin\TenantsController::addProgram()
     //  */
    public function testAddProgram(): void
    {
        $this->setAuthSession();

        $this->get('/admin/tenants/add-program');
        $this->assertResponseCode(200);

        $this->post('/admin/tenants/add-program' , [
            'name' => 'Nuevo programa test',
            'abbr' => 'INF'
        ]);

        $this->assertResponseContains('Nuevo programa test');
    }

    /**
     * Test addInterestArea method
     *
     * @return void
     * @uses \App\Controller\Admin\TenantsController::addInterestArea()
     */
    public function testAddInterestArea(): void
    {
        $this->setAuthSession();

        $program = ProgramFactory::make()->persist();

        $this->get('/admin/tenants/add-interest-area/'. $program->id);
        $this->assertResponseCode(200);

        $this->post('/admin/tenants/add-interest-area/'.$program->id, [
            'name' => 'Area de interes',
            'Description' => 'Campo descripcion',
            'program_id' => $program->id
        ]);

        $this->get('/admin/tenants/view-program/'.$program->id);
        $this->assertResponseCode(200);
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\Admin\TenantsController::edit()
     */
    public function testEdit(): void
    {
        $this->setAuthSession();

        $program = ProgramFactory::make()->persist();
        $lapse = LapseFactory::make([
            'tenant_id' => $this->tenant_id
        ])->persist();

        $tenant = TenantFactory::make([
            'program_id' => $program->id
        ])->persist();

        $this->get('/admin/tenants/view/' . $tenant->id);
        $this->assertResponseCode(200);

        $this->assertEquals(True, $lapse->active);

        $this->assertResponseContains($program->name);
        $this->assertResponseContains($program->abbr);
    }

    /**
     * Test editProgram method
     *
     * @return void
     * @uses \App\Controller\Admin\TenantsController::editProgram()
     */
    public function testEditProgram(): void
    {
        $this->setAuthSession();

        $program = ProgramFactory::make()->persist();

        $this->get('/admin/tenants/edit-program/' . $program->id);
        $this->assertResponseCode(200);

        $this->post('/admin/tenants/edit-program/' . $program->id, [
            'name' => 'Programa editado',
        ]);
        $this->assertResponseCode(302);

        $this->get('/admin/tenants/view-program/' . $program->id);
        $this->assertResponseContains('Programa editado');
        $this->assertResponseNotContains($program->name);
    }

    /**
     * Test editInterestArea method
     *
     * @return void
     * @uses \App\Controller\Admin\TenantsController::editInterestArea()
     */
    public function testEditInterestArea(): void
    {
        $this->setAuthSession();

        $program = ProgramFactory::make()->persist();
        $area_interes = InterestAreaFactory::make([
            'program_id' => $program->id
        ])->persist();

        $this->get('/admin/tenants/edit-interest-area/' . $area_interes->id);
        $this->assertResponseCode(200);

        $this->post('/admin/tenants/edit-interest-area/' . $area_interes->id, [
            'name' => 'Name area interest editing',
        ]);
        $this->assertResponseCode(302);

        $this->get('/admin/tenants/view-program/' . $program->id);
        $this->assertResponseContains('Name area interest editing');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\Admin\TenantsController::delete()
     */
    // public function testDelete(): void
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }
}
