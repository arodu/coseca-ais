<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Student;

use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Test\Factory\LapseDateFactory;
use App\Test\Traits\CommonTestTrait;
use Cake\I18n\FrozenDate;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\Utility\Hash;

/**
 * App\Controller\Student\DashboardController Test Case
 *
 * @uses \App\Controller\Student\DashboardController
 */
class DashboardControllerRegisterTest extends TestCase
{
    use IntegrationTestTrait;
    use CommonTestTrait;

    protected $program;
    protected $tenant;
    protected $student;
    protected $institution;
    protected $tutor;
    protected $user;
    protected $lapse;
    protected $lapse_id;
    protected $lapseDate;

    protected function setUp(): void
    {
        parent::setUp();

        //$lapse = LapseFactory::make()
        //    ->with('LapseDates');
        //;

        $this->program = $this->createProgram([
            //'lapses' => $lapse,
        ])->persist();
        $this->tenant = Hash::get($this->program, 'tenants.0');
        $this->institution = $this->createInstitution(['tenant_id' => $this->tenant->id])->persist();
        $this->tutor = $this->createTutor(['tenant_id' => $this->tenant->id])->persist();
        $this->lapse = Hash::get($this->program, 'tenants.0.lapses.0');
        $this->lapse_id = $this->lapse->id;
        // fecha de registro no activa
        $this->lapseDate = LapseDateFactory::make([
            'lapse_id' => $this->lapse_id,
            'title' => 'Registro',
            'stage' => StageField::REGISTER->value,
        ]);
        $this->student = $this->createStudent(['tenant_id' => $this->tenant->id])->persist();
        $this->user = $this->setAuthSession(Hash::get($this->student, 'app_user'));
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->program);
        unset($this->tenant);
        unset($this->student);
        unset($this->lapse);
        unset($this->lapse_id);
        unset($this->lapseDate);
        unset($this->institution);
        unset($this->tutor);
        unset($this->user);
    }

    /// Status: En proceso  ///
    //Sin lapso o periodo no activo

    public function testRegisterNoLapseActive(): void
    {
        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::REGISTER,
            'status' => StageStatus::IN_PROGRESS,
        ])->persist();

        $this->get('/student');
        $this->assertResponseCode(404, 'Actualmente no se encuentra un período activo, contacte la Coordinación de Servicio Comunitario. /logout');
    }

    //No existe fecha para el registro

    public function testRegisterNotExistLapseDate(): void
    {
        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::REGISTER,
            'status' => StageStatus::IN_PROGRESS,
        ])->persist();

        $this->lapseDate->persist();

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('No existe fecha de registro');
        $this->assertResponseContains($this->alertMessage);
    }

    //Ya pasó la fecha de registro

    public function testRegisterSubLapseDate(): void
    {
        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::REGISTER,
            'status' => StageStatus::IN_PROGRESS,
        ])->persist();

        $lapseDateEntity = $this->lapseDate->persist();
        $lapseDateEntity->start_date = FrozenDate::now()->subDays(1);
        $lapseDateEntity->end_date = FrozenDate::now()->subDays(1);
        $this->lapseDate->getTable()->saveOrFail($lapseDateEntity);

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('Ya pasó el período de registro');
        $this->assertResponseContains($this->alertMessage);
    }

    //Fecha para el registro mostrada

    public function testRegisterShowLapseDate(): void
    {
        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::REGISTER,
            'status' => StageStatus::IN_PROGRESS,
        ])->persist();

        $lapseDateEntity = $this->lapseDate->persist();
        $lapseDateEntity->start_date = FrozenDate::now()->addDays(1);
        $lapseDateEntity->end_date = FrozenDate::now()->addDays(1);
        $this->lapseDate->getTable()->saveOrFail($lapseDateEntity);

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains(__('Fecha de registro: {0}', $lapseDateEntity->show_dates));
        $this->assertResponseContains($this->alertMessage);
    }

    //Fecha para el registro mostrada con más tiempo

    public function testRegisterLapse2(): void
    {
        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::REGISTER,
            'status' => StageStatus::IN_PROGRESS,
        ])->persist();

        $lapseDateEntity = $this->lapseDate->persist();
        $lapseDateEntity->start_date = FrozenDate::now()->subDays(1);
        $lapseDateEntity->end_date = FrozenDate::now()->addDays(1);
        $this->lapseDate->getTable()->saveOrFail($lapseDateEntity);

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains(__('Fecha de registro: {0}', $lapseDateEntity->show_dates));
        $this->assertResponseContains('<a href="/student/register" type="button"');
        $this->assertResponseContains('Formulario de registro');
    }

    ///  ---  ///

    /// Status: En revisión  ///

    public function testRegisterCardStatusReview(): void
    {
        $this->createStudentStage([
            'user_id' => $this->user->id,
            'student_id' => $this->student->id,
            'lapse_id' => $this->lapse_id,
            'stage' => StageField::REGISTER,
            'status' => StageStatus::REVIEW,
        ])->persist();

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('En espera de revisión de documentos.');
    }

    /// Status: En espera  ///

    public function testRegisterCardStatusWaiting(): void
    {
        $this->createStudentStage([
            'user_id' => $this->user->id,
            'student_id' => $this->student->id,
            'lapse_id' => $this->lapse_id,
            'stage' => StageField::REGISTER,
            'status' => StageStatus::WAITING,
        ])->persist();

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('Sin información a mostrar');
    }

    /// Status: En realizado  ///
    public function testRegisterCardStatusSuccess(): void
    {
        $this->createStudentStage([
            'user_id' => $this->user->id,
            'student_id' => $this->student->id,
            'stage' => StageField::REGISTER,
            'status' => StageStatus::SUCCESS,
        ])->persist();

        /*  @FIXME
        *   warning: 2 :: Attempt to read property "name" on null on line 27 of /var/www/html/templates/Student/element/stages/*   register/success.php
        */
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains(Hash::get($this->user, 'dni'));
        $this->assertResponseContains(Hash::get($this->user, 'first_name'));
        $this->assertResponseContains(Hash::get($this->user, 'last_name'));
        $this->assertResponseContains(Hash::get($this->user, 'email'));
        $this->assertResponseContains($this->program->name . ' | ' . $this->program->tenants[0]->location->name);
    }
}
