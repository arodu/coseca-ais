<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller\Student;

use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Model\Field\StudentType;
use App\Model\Field\UserRole;
use App\Test\Factory\AppUserFactory;
use App\Test\Factory\CreateDataTrait;
use App\Test\Factory\ProgramFactory;
use App\Test\Factory\StudentStageFactory;
use Cake\I18n\FrozenDate;
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
    use CreateDataTrait;

    protected $program;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->enableRetainFlashMessages();
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->program = $this->createProgram()->persist(true);
        $this->user = $this->createUser(['role' => UserRole::STUDENT->value])->persist();
    }

    protected function tearDown(): void
    {
        unset($this->program);
        unset($this->user);

        parent::tearDown();
    }

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\Student\StagesController::index()
     */
    public function testStudentRegularOk(): void
    {
        $student = $this->createStudent([
            'type' => StudentType::REGULAR->value,
            'user_id' => $this->user->id,
            'tenant_id' => $this->program->tenants[0]->id,
        ])->persist();

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
        $student = $this->createStudent([
            'type' => StudentType::VALIDATED->value,
            'user_id' => $this->user->id,
            'tenant_id' => $this->program->tenants[0]->id,
        ])->persist();

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

    public function testRegisterInProgressTab(): void
    {
        $student = $this->createStudent([
            'type' => StudentType::REGULAR->value,
            'user_id' => $this->user->id,
            'tenant_id' => $this->program->tenants[0]->id,
        ])->persist();
        $lapse_id = Hash::get($this->program, 'tenants.0.lapses.0.id');

        $this->setDefaultLapseDates($lapse_id);

        $stageRegistry = $this->createStudentStage([
            'student_id' => $student->id,
            'stage' => StageField::REGISTER->value,
            'status' => StageStatus::IN_PROGRESS->value,
            'lapse_id' => $lapse_id,
        ])->persist();

        $this->session(['Auth' => $this->user]);

        // whitout lapse dates
        $this->get('/student/stages');
        $this->assertResponseOk();
        $this->assertResponseContains('No existe fecha de registro');
        $this->assertResponseContains('Comuníquese con la Coordinación de Servicio Comunitario para más información.');

        // with lapse dates in pass
        $this->changeLapseDate($lapse_id, StageField::REGISTER, FrozenDate::now()->subDays(4), FrozenDate::now()->subDays(3));
        $this->get('/student/stages');
        $this->assertResponseOk();
        $this->assertResponseContains('Ya pasó el período de registro');
        $this->assertResponseContains('Comuníquese con la Coordinación de Servicio Comunitario para más información.');

        // with lapse dates in future
        $dates = $this->changeLapseDate($lapse_id, StageField::REGISTER, FrozenDate::now()->addDays(3), FrozenDate::now()->addDays(4));
        $this->get('/student/stages');
        $this->assertResponseOk();
        $this->assertResponseContains(__('Fecha de registro: {0}', $dates->show_dates));
        $this->assertResponseContains('Comuníquese con la Coordinación de Servicio Comunitario para más información.');

        // with lapse dates in progress
        $this->changeLapseDate($lapse_id, StageField::REGISTER, FrozenDate::now()->subDays(1), FrozenDate::now()->addDays(1));
        $this->get('/student/stages');
        $this->assertResponseOk();
        $this->assertResponseContains('Formulario de registro');
    }
}
