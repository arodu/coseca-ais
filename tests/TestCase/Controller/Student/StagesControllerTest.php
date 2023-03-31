<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller\Student;

use App\Controller\Student\StagesController;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Model\Field\StudentType;
use App\Model\Field\UserRole;
use App\Test\Factory\AppUserFactory;
use App\Test\Factory\ProgramFactory;
use App\Test\Factory\StudentStageFactory;
use App\Utility\Stages;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\Utility\Hash;

/**
 * App\Controller\Student\StagesController Test Case
 *
 * @uses \App\Controller\Student\StagesController
 */
class StagesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->enableRetainFlashMessages();
        $this->enableCsrfToken();
        $this->enableSecurityToken();
    }

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\Student\StagesController::index()
     */
    public function testStudentRegularOk(): void
    {
        $program = ProgramFactory::make()->withTenants()->persist();
        $this->user = AppUserFactory::getUserStudent(
            StudentType::REGULAR,
            Hash::get($program, 'tenants.0.id')
        )->persist();
        $this->session(['Auth' => $this->user]);

        $this->get('/student/stages');

        $this->assertResponseOk();
        $this->assertResponseContains('Registro');
        $this->assertResponseContains('Taller');
        $this->assertResponseContains('Adscripción');
        $this->assertResponseContains('Seguimiento');
        $this->assertResponseContains('Resultados');
        $this->assertResponseContains('Conclusión');
        $this->assertResponseNotContains('Convalidación');
    }

    public function testStudentValidatedOk(): void
    {
        $program = ProgramFactory::make()->withTenants()->persist();
        $this->user = AppUserFactory::getUserStudent(
            StudentType::VALIDATED,
            Hash::get($program, 'tenants.0.id')
        )->persist();

        $this->session(['Auth' => $this->user]);

        $this->get('/student/stages');

        $this->assertResponseOk();
        $this->assertResponseContains('Registro');
        $this->assertResponseNotContains('Taller');
        $this->assertResponseNotContains('Adscripción');
        $this->assertResponseNotContains('Seguimiento');
        $this->assertResponseNotContains('Resultados');
        $this->assertResponseNotContains('Conclusión');
        $this->assertResponseContains('Convalidación');
    }


    public function testRegisterTab(): void
    {
        $program = ProgramFactory::make()->withTenants()->persist();
        $this->user = AppUserFactory::getUserStudent(
            StudentType::REGULAR,
            Hash::get($program, 'tenants.0.id')
        )->persist();

        StudentStageFactory::make([
            'student_id' => Hash::get($this->user, 'students.0.id'),
            'stage' => StageField::REGISTER->value,
            'status' => StageStatus::IN_PROGRESS->value,
        ])->persist();

        $this->session(['Auth' => $this->user]);

        $this->get('/student/stages');

        $this->assertResponseOk();

        debug($this->_response);
    }
}
