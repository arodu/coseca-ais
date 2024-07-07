<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Student;

use App\Model\Field\AdscriptionStatus;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Test\Factory\LapseDateFactory;
use App\Test\Factory\StudentTrackingFactory;
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
class DashboardControllerTrackingTest extends TestCase
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

        $this->program = $this->createProgram()->persist();
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

    public function testTrackingCardStatusInProgressWhitoutLapseDates(): void
    {
        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::TRACKING,
            'status' => StageStatus::IN_PROGRESS,
        ])->persist();

        // whitout lapse dates
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('El estudiante no tiene proyectos adscritos');
        $this->assertResponseContains($this->alertMessage);
    }

    public function testTrackingCardStatusInProgress(): void
    {
        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::TRACKING,
            'status' => StageStatus::IN_PROGRESS,
        ])->persist();

        $this->createAdscription([
            'student_id' => $this->student->id,
            'institution_project_id' => $this->institution->institution_projects[0]->id,
            'tutor_id' => $this->tutor->id,
            'status' => AdscriptionStatus::OPEN->value,
        ])->persist();

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('<h5 class="tracking-count description-header">0</h5>');
        $this->assertResponseContains('<h5 class="tracking-first-date description-header"><code>N/A</code></h5>');
        $this->assertResponseContains('<h5 class="tracking-last-date description-header"><code>N/A</code></h5>');
        $this->assertResponseContains('<h5 class="total-hours description-header">0</h5>');
        $this->assertResponseContains('Registro de actividades');
        $this->assertResponseNotContains('Planilla de actividades');
    }

    public function testTrackingCardStatusInProgressWithLapseDate(): void
    {
        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::TRACKING,
            'status' => StageStatus::IN_PROGRESS,
        ])->persist();

        $adscription = $this->createAdscription([
            'student_id' => $this->student->id,
            'institution_project_id' => $this->institution->institution_projects[0]->id,
            'tutor_id' => $this->tutor->id,
            'status' => AdscriptionStatus::OPEN->value,
        ])->persist();

        $first_date = FrozenDate::now()->subDays(4);
        StudentTrackingFactory::make([
            'student_adscription_id' => $adscription->id,
            'date' => $first_date,
            'hours' => 4,
            'description' => 'test',
        ])->persist();

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('<h5 class="tracking-count description-header">' . 1 . '</h5>');
        $this->assertResponseContains('<h5 class="tracking-first-date description-header">' . $first_date . '</h5>');
        $this->assertResponseContains('<h5 class="tracking-last-date description-header">' . $first_date . '</h5>');
        $this->assertResponseContains('<h5 class="total-hours description-header">' . 4 . '</h5>');
        $this->assertResponseContains('Registro de actividades');
        $this->assertResponseNotContains('Planilla de actividades');
    }

    public function testTrackingCardStatusReview(): void
    {

        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::TRACKING,
            'status' => StageStatus::REVIEW,
        ])->persist();

        $adscription = $this->createAdscription([
            'student_id' => $this->student->id,
            'institution_project_id' => $this->institution->institution_projects[0]->id,
            'tutor_id' => $this->tutor->id,
            'status' => AdscriptionStatus::CLOSED->value,
        ])->persist();

        $first_date = FrozenDate::now();
        $last_date = FrozenDate::now();

        StudentTrackingFactory::make([
            'student_adscription_id' => $adscription->id,
            'date' => $last_date,
            'hours' => 120,
            'description' => 'test',
        ])->persist();

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('<h5 class="tracking-count description-header">' . 1 . '</h5>');
        $this->assertResponseContains('<h5 class="tracking-first-date description-header">' . $first_date . '</h5>');
        $this->assertResponseContains('<h5 class="tracking-last-date description-header">' . $last_date . '</h5>');
        $this->assertResponseContains('<h5 class="total-hours description-header">' . 120 . '</h5>');
        $this->assertResponseContains('Registro de actividades');
        $this->assertResponseContains('Planilla 007');
    }
}
