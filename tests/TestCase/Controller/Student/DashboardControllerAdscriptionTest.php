<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Student;

use App\Test\Traits\CommonTestTrait;
use App\Model\Field\AdscriptionStatus;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use Cake\TestSuite\TestCase;
use Cake\Utility\Hash;
use Cake\TestSuite\IntegrationTestTrait;

/**
 * App\Controller\Student\DashboardController Test Case
 *
 * @uses \App\Controller\Student\DashboardController
 */
class DashboardControllerAdscriptionTest extends TestCase
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

    public function testAdscriptionCardStatusWaiting(): void
    {

        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::ADSCRIPTION,
            'status' => StageStatus::WAITING,
        ])->persist();
        

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('El estudiante no tiene proyectos adscritos');
        $this->assertResponseContains($this->alertMessage);
        $this->assertResponseNotContains('Sin información a mostrar');
    }

    public function testAdscriptionCardStatusInProgress(): void
    {
        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::ADSCRIPTION,
            'status' => StageStatus::IN_PROGRESS,
        ])->persist();
        

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('El estudiante no tiene proyectos adscritos');
        $this->assertResponseContains($this->alertMessage);
        $this->assertResponseNotContains('Sin información a mostrar');
    }

    public function testAdscriptionCardStatusPending()
    {
        $project = Hash::get($this->institution, 'institution_projects.0');

        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::ADSCRIPTION,
            'status' => StageStatus::IN_PROGRESS,
        ])->persist();

        
        $this->createAdscription([
            'student_id' => $this->student->id,
            'institution_project_id' => $project->id,
            'tutor_id' => $this->tutor->id,
            'status' => AdscriptionStatus::PENDING,
        ])->persist();

        
        $project_label_name = __('{0}: {1}', $this->institution->name, $project->name);

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains($project_label_name);
        $this->assertResponseContains('<span class="badge badge-warning">Pendiente</span>');
        $this->assertResponseContains('<dd class="col-sm-8">' . $this->institution->name . '</dd>');
        $this->assertResponseContains('<dd class="col-sm-8">' . $this->institution->contact_person . '</dd>');
        $this->assertResponseContains('<dd class="col-sm-8">' . $this->institution->contact_phone . '</dd>');
        $this->assertResponseContains('<dd class="col-sm-8">' . $this->institution->contact_email . '</dd>');
        $this->assertResponseContains('<dd class="col-sm-8">' . $project->name . '</dd>');
        $this->assertResponseContains('<dd class="col-sm-8">' . $this->tutor->name . '</dd>');
        $this->assertResponseContains('<dd class="col-sm-8">' . $this->tutor->phone . '</dd>');
        $this->assertResponseContains('<dd class="col-sm-8">' . $this->tutor->email . '</dd>'); 

    }

    public function testAdscriptionCardStatusClosed()
    {
        $project = Hash::get($this->institution, 'institution_projects.0');

        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::ADSCRIPTION,
            'status' => StageStatus::REVIEW,
        ])->persist();
        
        $this->createAdscription([
            'student_id' => $this->student->id,
            'institution_project_id' => $project->id,
            'tutor_id' => $this->tutor->id,
            'status' => AdscriptionStatus::CLOSED,
        ])->persist();

        $project_label_name = __('{0}: {1}', $this->institution->name, $project->name);

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains($project_label_name);

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains($project_label_name);
        $this->assertResponseContains('<span class="badge badge-danger">Cerrado</span>');
        $this->assertResponseNotContains('Planilla de adscripción');

    }

    public function testAdscriptionCardStatusOpen()
    {
        $project = Hash::get($this->institution, 'institution_projects.0');

        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::ADSCRIPTION,
            'status' => StageStatus::IN_PROGRESS,
        ])->persist();
        
        $this->createAdscription([
            'student_id' => $this->student->id,
            'institution_project_id' => $project->id,
            'tutor_id' => $this->tutor->id,
            'status' => AdscriptionStatus::OPEN,
        ])->persist();

        $project = Hash::get($this->institution, 'institution_projects.0');
        
        $project_label_name = __('{0}: {1}', $this->institution->name, $project->name);

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains($project_label_name);
        $this->assertResponseContains('<span class="badge badge-success">Abierto</span>');
        $this->assertResponseNotContains('Planilla de adscripción');

    }

    public function testAdscriptionCardStatusValidated()
    {

        $project = Hash::get($this->institution, 'institution_projects.0');

        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::ADSCRIPTION,
            'status' => StageStatus::SUCCESS,
        ])->persist();
        
        $this->createAdscription([
            'student_id' => $this->student->id,
            'institution_project_id' => $project->id,
            'tutor_id' => $this->tutor->id,
            'status' => AdscriptionStatus::VALIDATED,
        ])->persist();

        $project_label_name = __('{0}: {1}', $this->institution->name, $project->name);

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains($project_label_name);
        $this->assertResponseContains('<span class="badge badge-primary">Validado</span>');
        $this->assertResponseNotContains('Planilla de adscripción');
        
    }

    public function testAdscriptionCardStatusCancelled()
    {

        $project = Hash::get($this->institution, 'institution_projects.0');

        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::ADSCRIPTION,
            'status' => StageStatus::FAILED,
        ])->persist();
        
        $this->createAdscription([
            'student_id' => $this->student->id,
            'institution_project_id' => $project->id,
            'tutor_id' => $this->tutor->id,
            'status' => AdscriptionStatus::CANCELLED,
        ])->persist();

        $project_label_name = __('{0}: {1}', $this->institution->name, $project->name);

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseNotContains($project_label_name);
        $this->assertResponseNotContains($project->name);
    }
}
