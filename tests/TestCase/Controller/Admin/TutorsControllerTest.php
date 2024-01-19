<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use App\Test\Factory\TutorFactory;
use Cake\TestSuite\IntegrationTestTrait;

/**
 * App\Controller\Admin\TutorsController Test Case
 *
 * @uses \App\Controller\Admin\TutorsController
 */
class TutorsControllerTest extends AdminTestCase
{
    use IntegrationTestTrait;

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\Admin\TutorsController::index()
     */
    public function testIndex(): void
    {
        $this->get('/admin/tutors');
        $this->assertResponseCode(302);

        $this->setAuthSession();
        $this->get('/admin/tutors');
        $this->assertResponseCode(200);

        $tutor = TutorFactory::make([
            'tenant_id' => $this->tenant_id,
            'name' => 'Tutor de prueba',
            'dni' => 12345678,
            'phone' => 00001234567,
            'email' => 'email@test.com'
        ])->persist();

        $this->get('/admin/tutors');
        $this->assertResponseContains($tutor->name);
        $this->assertResponseContains($tutor->dni);
        $this->assertResponseContains($tutor->phone);
        $this->assertResponseContains($tutor->email);
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\Admin\TutorsController::view()
     */
    public function testView(): void
    {
        $this->setAuthSession();
        $tutor = TutorFactory::make([
            'tenant_id' => $this->tenant_id
        ])->persist();

        $this->get('/admin/tutors/view/' . $tutor->id);
        $this->assertResponseCode(200);

        $this->assertResponseContains($tutor->name);
        $this->assertResponseContains($tutor->dni);
        $this->assertResponseContains($tutor->phone);
        $this->assertResponseContains($tutor->email);
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\Admin\TutorsController::add()
     */
    public function testAdd(): void
    {
        $this->setAuthSession();
        $this->get('/admin/tutors/add');
        $this->assertResponseCode(200);

        $tutor = TutorFactory::make([
            'tenant_id' => $this->tenant_id
        ])->persist();

        $this->get('/admin/tutors/');
        $this->assertResponseCode(200);

        $this->assertResponseContains($tutor->name);
        $this->assertResponseContains($tutor->dni);
        $this->assertResponseContains($tutor->phone);
        $this->assertResponseContains($tutor->email);
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\Admin\TutorsController::edit()
     */
    public function testEdit(): void
    {
        $this->setAuthSession();

        $tutor = TutorFactory::make([
            'tenant_id' => $this->tenant_id
        ])->persist();

        $this->get('/admin/tutors/edit/' . $tutor->id);
        $this->assertResponseCode(200);

        $this->post('/admin/tutors/edit/' . $tutor->id, [
            'name' => 'Edit tutor test',
        ]);
        $this->assertResponseCode(302);

        $this->get('/admin/tutors/view/' . $tutor->id);
        $this->assertResponseContains('Edit tutor test');
        $this->assertResponseNotContains($tutor->name);
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\Admin\TutorsController::delete()
     */
    public function testDelete(): void
    {
        $this->setAuthSession();

        $tutor = TutorFactory::make([
            'tenant_id' => $this->tenant_id
        ])->persist();

        $this->delete('/admin/tutors/delete/' . $tutor->id);

        $res = $this->getRecordExists('Tutors', $tutor->id);
        $this->assertTrue($res);
    }
}
