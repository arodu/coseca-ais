<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use App\Test\Factory\InstitutionFactory;
use Cake\TestSuite\IntegrationTestTrait;

/**
 * App\Controller\Admin\InstitutionsController Test Case
 *
 * @uses \App\Controller\Admin\InstitutionsController
 */
class InstitutionsControllerTest extends AdminTestCase
{
    use IntegrationTestTrait;

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\Admin\InstitutionsController::index()
     */
    public function testIndex(): void
    {
        $this->get('/admin/institutions');
        $this->assertResponseCode(302);

        $this->setAuthSession();
        $this->get('/admin/institutions');
        $this->assertResponseCode(200);

        $intitution = InstitutionFactory::make([
            'tenant_id' => $this->tenant_id,
        ])->persist();

        $this->get('/admin/institutions');
        $this->assertResponseContains($intitution->name);
        $this->assertResponseContains($intitution->contact_person);
        $this->assertResponseContains($intitution->contact_phone);
        $this->assertResponseContains($intitution->contact_email);
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\Admin\InstitutionsController::add()
     */
    public function testAddForm(): void
    {
        $this->setAuthSession();

        $this->get('/admin/institutions/add');
        $this->assertResponseCode(200);
    }

    public function testAddPost(): void
    {
        $this->setAuthSession();

        $this->post('/admin/institutions/add', [
            'name' => 'Institución de prueba',
            'contact_person' => 'Persona de prueba',
            'contact_phone' => '04141234567',
            'contact_email' => 'asd@asd.com',
            'tenant_id' => $this->tenant_id,
        ]);

        $this->assertResponseContains('Institución de prueba');
        $this->assertResponseContains('Persona de prueba');
        $this->assertResponseContains('04141234567');
        $this->assertResponseContains('asd@asd.com');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\Admin\InstitutionsController::view()
     */
    //public function testView(): void
    //{
    //    $this->markTestIncomplete('Not implemented yet.');
    //}

    /**
     * Test addProject method
     *
     * @return void
     * @uses \App\Controller\Admin\InstitutionsController::addProject()
     */
    //public function testAddProject(): void
    //{
    //    $this->markTestIncomplete('Not implemented yet.');
    //}

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\Admin\InstitutionsController::edit()
     */
    public function testEdit(): void
    {
        $this->setAuthSession();

        $intitution = InstitutionFactory::make([
            'tenant_id' => $this->tenant_id,
        ])->persist();

        $this->get('/admin/institutions/edit/' . $intitution->id);
        $this->assertResponseCode(200);

        $this->post('/admin/institutions/edit/' . $intitution->id, [
            'name' => 'prueba edit',
        ]);
        $this->assertResponseCode(302);

        $this->get('/admin/institutions/view/' . $intitution->id);
        $this->assertResponseContains('prueba edit');
        $this->assertResponseNotContains($intitution->name);
    }

    /**
     * Test editProject method
     *
     * @return void
     * @uses \App\Controller\Admin\InstitutionsController::editProject()
     */
    //public function testEditProject(): void
    //{
    //    $this->markTestIncomplete('Not implemented yet.');
    //}

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\Admin\InstitutionsController::delete()
     */
    //public function testDelete(): void
    //{
    //    $this->markTestIncomplete('Not implemented yet.');
    //}
}
