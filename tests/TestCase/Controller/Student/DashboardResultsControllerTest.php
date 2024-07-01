<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Student;

use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Test\Traits\CommonTestTrait;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\Utility\Hash;

/**
 * App\Controller\Student\DashboardRessultsController Test Case
 */
class DashboardResultsControllerTest extends TestCase
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

    public function testStatusWaiting(): void
    {
        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::RESULTS,
            'status' => StageStatus::WAITING,
        ])->persist();

        $this->get('/student');

        $this->assertResponseOk();
        $this->assertResponseContains($this->alertNoInfo);
        $this->assertResponseContains($this->alertMessage);
    }

    public function testStatusInProgress(): void
    {
        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::RESULTS,
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
            'stage' => StageField::RESULTS,
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
            'stage' => StageField::RESULTS,
            'status' => StageStatus::SUCCESS,
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
            'stage' => StageField::RESULTS,
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
            'stage' => StageField::RESULTS,
            'status' => StageStatus::LOCKED,
        ])->persist();

        $this->get('/student');

        $this->assertResponseOk();
        $this->assertResponseContains($this->alertNoInfo);
        $this->assertResponseContains($this->alertMessage);
    }
}
