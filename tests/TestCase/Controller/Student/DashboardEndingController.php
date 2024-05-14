<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Student;

use App\Model\Field\AdscriptionStatus;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Test\Traits\CommonTestTrait;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\Utility\Hash;

/**
 * App\Controller\Student\DashboardEndingController Test Case
 */
class DashboardEndingController extends TestCase
{
    use IntegrationTestTrait;
    use CommonTestTrait;

    protected $program;
    protected $tenant;
    protected $student;
    protected $institution;
    protected $tutor;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->program = $this->createProgram()->persist();
        $this->tenant = Hash::get($this->program, 'tenants.0');
        $this->student = $this->createStudent(['tenant_id' => $this->tenant->id])->persist();
        $this->institution = $this->createInstitution(['tenant_id' => $this->tenant->id])->persist();
        $this->tutor = $this->createTutor(['tenant_id' => $this->tenant->id])->persist();
        $this->user = $this->setAuthSession(Hash::get($this->student, 'app_user'));
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->program);
        unset($this->tenant);
        unset($this->student);
        unset($this->institution);
        unset($this->tutor);
        unset($this->user);
    }

    public function testWithoutStatus(): void
    {
        $this->get('/student');

        $this->assertResponseOk();
        $this->assertResponseContains(__('Conclusión'));
        $this->assertResponseContains('<i class="fas fa-lock fa-fw mr-1 ending"></i>');
    }

    public function testStatusWaiting(): void
    {
        $institutionProject = Hash::get($this->institution, 'institution_projects.0');
        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::ENDING,
            'status' => StageStatus::WAITING,
        ])->persist();
        $this->createAdscription([
            'student_id' => $this->student->id,
            'institution_project_id' => $institutionProject->id,
            'tutor_id' => $this->tutor->id,
            'status' => AdscriptionStatus::CLOSED,
        ])->persist();

        $this->get('/student');

        $this->assertResponseOk();
        $this->assertResponseContains(__('Conclusión'));
        $this->assertResponseContains('<i class="fas fa-pause fa-fw mr-1 ending"></i>');
        $this->assertResponseContains('<span class="badge badge-light">En espera</span>');
        $this->assertResponseContains(__('Estimado Prestador de Servicio Comunitario, estamos complacidos de haberte acompañado'));
        $this->assertResponseContains(__('Descargar planilla 009'));
        $this->assertResponseContains('<a href="/student/documents/format009/' . $this->student->dni . '_planilla009.pdf"');
    }

    public function testStatusWaitingWithOutAdscription(): void
    {
        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::ENDING,
            'status' => StageStatus::WAITING,
        ])->persist();

        $this->get('/student');

        $this->assertResponseOk();
        $this->assertResponseContains(__('Conclusión'));
        $this->assertResponseContains('<i class="fas fa-pause fa-fw mr-1 ending"></i>');
        $this->assertResponseContains('<span class="badge badge-light">En espera</span>');
        $this->assertResponseContains(__('Ha ocurrido un problema en la consolidación de los documentos'));
        $this->assertResponseContains($this->alertMessage);
    }

    public function testStatusInProgress(): void
    {
        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::ENDING,
            'status' => StageStatus::IN_PROGRESS,
        ])->persist();

        $this->get('/student');

        $this->assertResponseOk();
        $this->assertResponseContains($this->alertNoInfo);
        $this->assertResponseContains($this->alertMessage);
    }

    public function testStatusReview(): void
    {
        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::ENDING,
            'status' => StageStatus::REVIEW,
        ])->persist();

        $this->get('/student');

        $this->assertResponseOk();
        $this->assertResponseContains($this->alertNoInfo);
        $this->assertResponseContains($this->alertMessage);
    }

    public function testStatusSuccess(): void
    {
        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::ENDING,
            'status' => StageStatus::REVIEW,
        ])->persist();

        $this->get('/student');

        $this->assertResponseOk();
        $this->assertResponseContains($this->alertNoInfo);
        $this->assertResponseContains($this->alertMessage);
    }

    public function testStatusFailed(): void
    {
        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::ENDING,
            'status' => StageStatus::FAILED,
        ])->persist();

        $this->get('/student');

        $this->assertResponseOk();
        $this->assertResponseContains($this->alertNoInfo);
        $this->assertResponseContains($this->alertMessage);
    }

    public function testStatusLocked(): void
    {
        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::ENDING,
            'status' => StageStatus::LOCKED,
        ])->persist();

        $this->get('/student');

        $this->assertResponseOk();
        $this->assertResponseContains($this->alertNoInfo);
        $this->assertResponseContains($this->alertMessage);
    }
}
