<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller\Student;

use App\Model\Entity\Student;
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
    protected $tenant_id;
    protected $user;
    protected $lapse_id;

    protected function setUp(): void
    {
        parent::setUp();

        $this->enableRetainFlashMessages();
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->program = $this->createProgram()->persist();
        $this->user = $this->createUser(['role' => UserRole::STUDENT->value])->persist();
        $this->tenant_id = Hash::get($this->program, 'tenants.0.id');
        $this->lapse_id = Hash::get($this->program, 'tenants.0.lapses.0.id');
        $this->setDefaultLapseDates($this->lapse_id);
    }

    protected function tearDown(): void
    {
        unset($this->program);
        unset($this->user);
        unset($this->lapse_id);

        parent::tearDown();
    }

    protected function createRegularStudent(): Student
    {
        $interest_area_key = rand(0, count($this->program->interest_areas) - 1);

        return $this->createStudent([
                'type' => StudentType::REGULAR->value,
                'user_id' => $this->user->id,
                'tenant_id' => $this->tenant_id,
                'lapse_id' => $this->lapse_id,
            ])
            ->with('StudentData', [
                'interest_area_id' => $this->program->interest_areas[$interest_area_key]->id,
            ])
            ->persist();
    }

    protected function createValidationStudent(): Student
    {
        $interest_area_key = rand(0, count($this->program->interest_areas) - 1);

        return $this->createStudent([
                'type' => StudentType::VALIDATED->value,
                'user_id' => $this->user->id,
                'tenant_id' => $this->tenant_id,
                'lapse_id' => $this->lapse_id,
            ])
            ->with('StudentData', [
                'interest_area_id' => $this->program->interest_areas[$interest_area_key]->id,
            ])
            ->persist();
    }

    public function testStudentRegularOk(): void
    {
        $this->createRegularStudent();

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
        $this->createValidationStudent();

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

    public function testRegisterCardInProgress(): void
    {
        $student = $this->createRegularStudent();
        $lapse_id = $this->lapse_id;

        $stageRegistry = $this->createStudentStage([
            'student_id' => $student->id,
            'stage' => StageField::REGISTER->value,
            'status' => StageStatus::IN_PROGRESS->value,
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

    public function testRegisterCardReview(): void
    {
        $student = $this->createRegularStudent();

        $stageRegistry = $this->createStudentStage([
            'student_id' => $student->id,
            'stage' => StageField::REGISTER->value,
            'status' => StageStatus::REVIEW->value,
        ])->persist();

        $this->session(['Auth' => $this->user]);

        $this->get('/student/stages');
        $this->assertResponseOk();
        $this->assertResponseContains('En espera de revisión de documentos.');
        $this->assertResponseContains('Comuníquese con la Coordinación de Servicio Comunitario para más información.');
    }

    public function testRegisterCardSuccess(): void
    {
        $student = $this->createRegularStudent();

        $stageRegistry = $this->createStudentStage([
            'student_id' => $student->id,
            'stage' => StageField::REGISTER->value,
            'status' => StageStatus::SUCCESS->value,
        ])->persist();

        $this->session(['Auth' => $this->user]);

        $this->get('/student/stages');
        $this->assertResponseOk();
        $this->assertResponseContains(Hash::get($this->user, 'dni'));
        $this->assertResponseContains(Hash::get($this->user, 'first_name'));
        $this->assertResponseContains(Hash::get($this->user, 'last_name'));
        $this->assertResponseContains(Hash::get($this->user, 'email'));
        $this->assertResponseContains($this->program->name . ', ' . $this->program->tenants[0]->name);
        $this->assertResponseContains(Hash::get($student, 'student_data.phone'));
    }

    public function testRegisterCardOtherStatuses(): void
    {
        $student = $this->createRegularStudent();

        $stageRegistry = $this->createStudentStage([
            'student_id' => $student->id,
            'stage' => StageField::REGISTER->value,
            'status' => StageStatus::WAITING->value,
        ])->persist();

        $this->session(['Auth' => $this->user]);

        $this->get('/student/stages');
        $this->assertResponseOk();
        $this->assertResponseContains('Sin información a mostrar');
        $this->assertResponseContains('Comuníquese con la Coordinación de Servicio Comunitario para más información.');

        $stageRegistry->status = StageStatus::FAILED->value;
        $this->updateStudentStage($stageRegistry);
        $this->get('/student/stages');
        $this->assertResponseOk();
        $this->assertResponseContains('Sin información a mostrar');
        $this->assertResponseContains('Comuníquese con la Coordinación de Servicio Comunitario para más información.');

        $stageRegistry->status = StageStatus::LOCKED->value;
        $this->updateStudentStage($stageRegistry);
        $this->get('/student/stages');
        $this->assertResponseOk();
        $this->assertResponseContains('Sin información a mostrar');
        $this->assertResponseContains('Comuníquese con la Coordinación de Servicio Comunitario para más información.');
    }

    public function testCourseCardWaiting(): void
    {
        $lapse_id = $this->lapse_id;
        $student = $this->createRegularStudent();
        $this->createStudentStage([
            'student_id' => $student->id,
            'stage' => StageField::COURSE->value,
            'status' => StageStatus::WAITING->value,
        ])->persist();

        $this->session(['Auth' => $this->user]);

        // whitout lapse dates
        $this->get('/student/stages');
        $this->assertResponseOk();
        $this->assertResponseContains('En espera de la fecha del taller de Servicio Comunitario');
        $this->assertResponseContains('Comuníquese con la Coordinación de Servicio Comunitario para más información.');
        
        // with lapse dates in pass
        $date = FrozenDate::now()->subDays(4);
        $this->changeLapseDate($lapse_id, StageField::COURSE, $date);
        $this->get('/student/stages');
        $this->assertResponseOk();
        $this->assertResponseContains('Fecha del taller de servicio comunitario: ' . $date . ' <small>(Caducado)</small>');
        $this->assertResponseContains('Comuníquese con la Coordinación de Servicio Comunitario para más información.');

        // with lapse dates in future
        $date = FrozenDate::now()->addDays(4);
        $this->changeLapseDate($lapse_id, StageField::COURSE, $date);
        $this->get('/student/stages');
        $this->assertResponseOk();
        $this->assertResponseContains('Fecha del taller de servicio comunitario: ' . $date . ' <small>(Pendiente)</small>');
        $this->assertResponseContains('Comuníquese con la Coordinación de Servicio Comunitario para más información.');

        // with lapse dates in progress
        $date = FrozenDate::now();
        $this->changeLapseDate($lapse_id, StageField::COURSE, $date);
        $this->get('/student/stages');
        $this->assertResponseOk();
        $this->assertResponseContains('Fecha del taller de servicio comunitario: ' . $date . ' <small>(En Progreso)</small>');
        $this->assertResponseContains('Comuníquese con la Coordinación de Servicio Comunitario para más información.');
    }

    public function testCourseCardSuccess(): void
    {
        $student = $this->createRegularStudent();
        $this->createStudentStage([
            'student_id' => $student->id,
            'stage' => StageField::COURSE->value,
            'status' => StageStatus::SUCCESS->value,
        ])->persist();

        $this->session(['Auth' => $this->user]);

        $this->get('/student/stages');
        $this->assertResponseOk();
        $this->assertResponseContains('Sin información a mostrar');
        $this->assertResponseContains('Comuníquese con la Coordinación de Servicio Comunitario para más información.');

        $courseDate = FrozenDate::now();
        $course = $this->createStudentCourse([
            'student_id' => $student->id,
            'date' => $courseDate,
        ])->persist();

        $this->get('/student/stages');
        $this->assertResponseOk();
        $this->assertResponseContains('<strong>Fecha del Taller: </strong>01/04/23');
        $this->assertResponseContains($course->comment);
    }

    public function testCourseCardOtherStatuses(): void
    {
        $student = $this->createRegularStudent();

        $stageRegistry = $this->createStudentStage([
            'student_id' => $student->id,
            'stage' => StageField::COURSE->value,
            'status' => StageStatus::IN_PROGRESS->value,
        ])->persist();

        $this->session(['Auth' => $this->user]);

        $this->get('/student/stages');
        $this->assertResponseOk();
        $this->assertResponseContains('Sin información a mostrar');
        $this->assertResponseContains('Comuníquese con la Coordinación de Servicio Comunitario para más información.');

        $stageRegistry->status = StageStatus::REVIEW->value;
        $this->updateStudentStage($stageRegistry);
        $this->get('/student/stages');
        $this->assertResponseOk();
        $this->assertResponseContains('Sin información a mostrar');
        $this->assertResponseContains('Comuníquese con la Coordinación de Servicio Comunitario para más información.');

        $stageRegistry->status = StageStatus::FAILED->value;
        $this->updateStudentStage($stageRegistry);
        $this->get('/student/stages');
        $this->assertResponseOk();
        $this->assertResponseContains('Sin información a mostrar');
        $this->assertResponseContains('Comuníquese con la Coordinación de Servicio Comunitario para más información.');

        $stageRegistry->status = StageStatus::LOCKED->value;
        $this->updateStudentStage($stageRegistry);
        $this->get('/student/stages');
        $this->assertResponseOk();
        $this->assertResponseContains('Sin información a mostrar');
        $this->assertResponseContains('Comuníquese con la Coordinación de Servicio Comunitario para más información.');
    }

}
