<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use App\Controller\Admin\AppUsersController;
use App\Model\Field\UserRole;
use App\Test\Factory\AppUserFactory;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use App\Test\Factory\CreateDataTrait;
use Cake\I18n\FrozenDate;
use Faker\Generator;

/**
 * App\Controller\Admin\AppUsersController Test Case
 *
 * @uses \App\Controller\Admin\AppUsersController
 */
class AppUsersControllerTest extends AdminTestCase
{
    use IntegrationTestTrait;

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\Admin\AppUsersController::index()
     */
    public function testIndex(): void
    {
        $this->get('/admin/app-users');
        $this->assertResponseCode(302);

        $this->setAuthSession();
        $this->get('/admin/app-users');
        $this->assertResponseCode(200);

        $user = $this->createUserWithAdminRole();

        $this->get('/admin/app-users');
        $this->assertResponseCode(200);

        $this->assertResponseContains($user->email);
        $this->assertResponseContains($user->first_name);
        $this->assertResponseContains($user->dni);
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\Admin\AppUsersController::view()
     */
    public function testView(): void
    {
        $this->setAuthSession();
        $user = $this->createUserWithAdminRole();

        $this->get('/admin/app-users/view/' . $user->id);
        $this->assertResponseCode(200);

        $this->assertResponseContains($user->email);
        $this->assertResponseContains($user->first_name);
        $this->assertResponseContains($user->dni);
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\Admin\AppUsersController::add()
     */
    public function testAdd(): void
    {
        $this->get('/admin/app-users/add');
        $this->assertResponseCode(302);

        $this->setAuthSession();
        $this->get('/admin/app-users/add');
        $this->assertResponseCode(200);

        $this->post('/admin/app-users/add', [
            'username' => 'Username test',
            'email' => 'email@test.aiscoseca',
            'dni' => '12345678',
            'first_name' => 'FirstName test',
            'last_name' => 'LastName test',
            'active' => true,
            'role' => UserRole::ADMIN->value,
            'created' => FrozenDate::now(),
            'modified' => FrozenDate::now(),
        ]);

        $this->assertResponseContains('Username test');
        $this->assertResponseContains('email@test.aiscoseca');
        $this->assertResponseContains('12345678');
        $this->assertResponseContains('FirstName test');
        $this->assertResponseContains('LastName test');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\Admin\AppUsersController::edit()
     */
    public function testEdit(): void
    {
        $this->setAuthSession();

        $user = $this->createUserWithAdminRole();

        $this->get('/admin/app-users/edit/' . $user->id);
        $this->assertResponseCode(200);

        $this->post('/admin/app-users/edit/' . $user->id, [
            'username' => 'Test edit username',
        ]);
        $this->assertResponseCode(302);

        $this->get('/admin/app-users/edit/' . $user->id);
        $this->assertResponseContains('Test edit username');
        $this->assertResponseNotContains($user->username);
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\Admin\AppUsersController::delete()
     */
    public function testDelete(): void
    {
        $this->setAuthSession();

        $user = $this->createUserWithAdminRole();
        $this->delete('/admin/app-users/edit/' . $user->id);

        $res = $this->getRecordExists('Users', $user->id);
        $this->assertTrue($res);
    }
}
