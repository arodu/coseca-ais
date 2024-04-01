<?php

declare(strict_types=1);

namespace Manager\Test\TestCase\Controller;

use App\Model\Field\UserRole;
use App\Test\Factory\AreaFactory;
use App\Test\Factory\ProgramFactory;
use App\Test\TestCase\Controller\Admin\AdminTestCase;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Laminas\Diactoros\UploadedFile;
use Manager\Controller\AreasController;

/**
 * Manager\Controller\AreasController Test Case
 *
 * @uses \Manager\Controller\AreasController
 */
class AreasControllerTest extends AdminTestCase
{
    use IntegrationTestTrait;

    /**
     * Test index method
     *
     * @return void
     * @uses \Manager\Controller\AreasController::index()
     */
    public function testIndex(): void
    {
        $this->get('/manager/areas/index');
        $this->assertResponseCode(302);

        $user = $this->createUser(['role' => UserRole::MANAGER->value])->persist();
        $this->setAuthSession($user);

        $this->get('/manager/areas/index');
        $this->assertResponseCode(200);

        $area = AreaFactory::make()->persist();
        $this->get('/manager/areas/index');
        $this->assertResponseCode(200);
        $this->assertResponseContains($area->name);
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \Manager\Controller\AreasController::view()
     */
    public function testView(): void
    {
        $this->get('/manager/areas/view/1');
        $this->assertResponseCode(302);

        $user = $this->createUser(['role' => UserRole::MANAGER->value])->persist();
        $this->setAuthSession($user);

        $area = AreaFactory::make()->persist();
        $this->get('/manager/areas/view/' . $area->id);
        $this->assertResponseCode(200);

        $area = AreaFactory::make(['logo' => '/uploads/areas/AIS.png'])
            ->with('Programs')
            ->persist();
        $this->get('/manager/areas/view/' . $area->id);
        $this->assertResponseCode(200);
        $this->assertResponseContains($area->name);
        $this->assertResponseContains($area->programs[0]->name);
        $this->assertResponseContains('<img src="/uploads/areas/AIS.png"');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \Manager\Controller\AreasController::add()
     */
    public function testAdd(): void
    {
        $this->get('/manager/areas/add');
        $this->assertResponseCode(302);

        $user = $this->createUser(['role' => UserRole::MANAGER->value])->persist();
        $this->setAuthSession($user);

        $this->get('/manager/areas/add');
        $this->assertResponseCode(200);

        $this->post('/manager/areas/add', [
            'name' => 'Test Area',
            'print_label' => 'Test Area',
            'abbr' => 'TA',
        ]);
        $this->assertResponseCode(302);

        $area = AreaFactory::find()->all()->last();
        $this->assertNotEmpty($area);
        $this->assertEquals('Test Area', $area->name);
        $this->assertEquals('Test Area', $area->print_label);
        $this->assertEquals('TA', $area->abbr);
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \Manager\Controller\AreasController::edit()
     */
    public function testEdit(): void
    {
        $this->get('/manager/areas/edit/1');
        $this->assertResponseCode(302);

        $user = $this->createUser(['role' => UserRole::MANAGER->value])->persist();
        $this->setAuthSession($user);

        $this->get('/manager/areas/edit/1');
        $this->assertResponseCode(404);

        $this->setAuthSession($user);
        $area = AreaFactory::make()->persist();
        $this->get('/manager/areas/edit/' . $area->id);
        $this->assertResponseCode(200);

        $this->post('/manager/areas/edit/' . $area->id, [
            'name' => 'Test Area',
            'print_label' => 'Test Area',
            'abbr' => 'TA',
        ]);
        $this->assertResponseCode(302);

        $area = AreaFactory::find()->all()->last();
        $this->assertNotEmpty($area);
        $this->assertEquals('Test Area', $area->name);
        $this->assertEquals('Test Area', $area->print_label);
        $this->assertEquals('TA', $area->abbr);
    }

    /**
     * Test editLogo method
     *
     * @return void
     * @uses \Manager\Controller\AreasController::editLogo()
     */
    public function testEditLogo(): void
    {
        $this->get('/manager/areas/edit-logo/1');
        $this->assertResponseCode(302);

        $user = $this->createUser(['role' => UserRole::MANAGER->value])->persist();
        $this->setAuthSession($user);

        $this->get('/manager/areas/edit-logo/1');
        $this->assertResponseCode(404);

        $this->setAuthSession($user);
        $area = AreaFactory::make()->persist();
        $this->get('/manager/areas/edit-logo/' . $area->id);
        $this->assertResponseCode(200);

        $file = new UploadedFile(fopen(ROOT . '/tests/files/AIS.png', 'r'), 1024, UPLOAD_ERR_OK, 'logo.png', 'image/png');
        $this->post('/manager/areas/edit-logo/' . $area->id, [
            'logo' => $file
        ]);
        \Cake\Log\Log::debug((string) $this->_response->getBody());
        $this->assertResponseCode(302);

        $area = AreaFactory::get($area->id);
        $this->assertNotEmpty($area);
        $this->assertStringContainsString('uploads/areas/' . $area->abbr . '.png', $area->logo);
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \Manager\Controller\AreasController::delete()
     */
    public function testDelete(): void
    {
        $this->post('/manager/areas/delete/1');
        $this->assertResponseCode(302);

        $user = $this->createUser(['role' => UserRole::MANAGER->value])->persist();
        $this->setAuthSession($user);

        $this->post('/manager/areas/delete/1');
        $this->assertResponseCode(404);

        $area = AreaFactory::make()->persist();
        $this->post('/manager/areas/delete/' . $area->id);
        $this->assertResponseCode(302);

        $area = AreaFactory::find()
            ->where(['id' => $area->id, 'deleted IS' => null])
            ->first();
        $this->assertEmpty($area);
    }
}
