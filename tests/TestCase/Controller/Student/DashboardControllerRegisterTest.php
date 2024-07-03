<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Student;

use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Test\Factory\LapseDateFactory;
use App\Test\Factory\LapseFactory;
use App\Test\Traits\CommonTestTrait;
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
        unset($this->institution);
        unset($this->tutor);
        unset($this->user);
    }

    public function testRegisterNoLapseActive(): void
    {
        //$lapseDate = LapseDateFactory::make([
        //    'lapse_id' => $this->lapse_id,
        //    'title' => 'Registro',
        //    'stage' => StageField::REGISTER->value,
        //    'start_date' => date('Y-m-d', strtotime('+1 day')),
        //    'end_date' => date('Y-m-d', strtotime('+1 day')),
        //])->persist();

        $this->createStudentStage([
        'student_id' => $this->student->id,
        'stage' => StageField::REGISTER,
        'status' => StageStatus::IN_PROGRESS,
        ])->persist();

        $this->get('/student');

        //$this->debugResponse();

        $this->assertResponseContains('Ya pasó el período de registro');
        $this->assertResponseContains('Comuniquese con la coordinación de servicio comunitario para mas información');
    }

    public function testRegisterCardStatusReview(): void
    {

        //$lapseDate = LapseDateFactory::make([
        //    'lapse_id' => $this->lapse_id,
        //    'title' => 'Registro',
        //    'stage' => StageField::REGISTER->value,
        //    'start_date' => date('Y-m-d', strtotime('+1 day')),
        //    'end_date' => date('Y-m-d', strtotime('+1 day')),
        //])->persist();

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

    public function testRegisterCardStatusSuccess(): void
    {
        $this->createStudentStage([
        'user_id' => $this->user->id,
        'student_id' => $this->student->id,
        'lapse_id' => $this->lapse_id,
        'stage' => StageField::REGISTER,
        'status' => StageStatus::SUCCESS,
        ])->persist();

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains(Hash::get($this->user, 'dni'));
        $this->assertResponseContains(Hash::get($this->user, 'first_name'));
        $this->assertResponseContains(Hash::get($this->user, 'last_name'));
        $this->assertResponseContains(Hash::get($this->user, 'email'));
        $this->assertResponseContains($this->program->name . ' | ' . $this->program->tenants[0]->location->name);
    }
}
