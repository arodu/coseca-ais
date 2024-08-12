<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Student;

use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Test\Factory\LapseDateFactory;
use App\Test\Factory\StudentCourseFactory;
use App\Test\Traits\CommonTestTrait;
use Cake\I18n\FrozenDate;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\Utility\Hash;

/**
 * App\Controller\Student\DashboardCourseController Test Case
 */

class DashboardCourseControllerTest extends TestCase
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
    protected $lapseDateEntity;

    protected function setUp(): void
    {
        parent::setUp();

        $this->program = $this->createProgram()->persist();
        $this->tenant = Hash::get($this->program, 'tenants.0');
        $this->lapse = Hash::get($this->program, 'tenants.0.lapses.0');
        $this->lapse_id = $this->lapse->id;
        $this->student = $this->createStudent(['tenant_id' => $this->tenant->id])->persist();
        $this->institution = $this->createInstitution(['tenant_id' => $this->tenant->id])->persist();
        $this->tutor = $this->createTutor(['tenant_id' => $this->tenant->id])->persist();
        $this->user = $this->setAuthSession(Hash::get($this->student, 'app_user'));

        $this->lapseDate = LapseDateFactory::make([
            'lapse_id' => $this->lapse_id,
            'title' => 'Taller',
            'stage' => StageField::COURSE->value,
            'start_date' => null,
            'end_date' => null,
        ]);

        $this->lapseDateEntity = $this->lapseDate->persist();
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
        unset($this->lapse);
        unset($this->lapse_id);
        unset($this->lapseDate);
        unset($this->lapseDateEntity);
    }

    public function testCourseCardStatusLocked(): void
    {
        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::COURSE,
            'status' => StageStatus::LOCKED,
        ])->persist();

        // whitout lapse dates
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('fas fa-lock fa-fw mr-1 course');
        $this->assertResponseContains('<span class="badge badge-light">Bloqueado</span>');
        //debug($taller);
        //debug($this->lapse_id);
        //debug($this->lapseDateEntity);
        $this->debugResponse(true);
    }

    public function testCourseCardStatusWaiting(): void
    {
        $this->createStudentStage([
           'student_id' => $this->student->id,
           'stage' => StageField::COURSE,
           'status' => StageStatus::WAITING,
           'lapse_id' => $this->lapse_id,
        ])->persist();

        // date expired
        $this->lapseDateEntity->start_date = FrozenDate::now()->subDays(4);
        $this->lapseDate->getTable()->saveOrFail($this->lapseDateEntity);
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('<p>Fecha del taller de servicio comunitario:  <small>(Caducado)</small></p>');
        $this->assertResponseContains($this->alertMessage);

        // pending date
        $this->lapseDateEntity->start_date = FrozenDate::now()->addDays(4);
        $this->lapseDate->getTable()->saveOrFail($this->lapseDateEntity);
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('<p>Fecha del taller de servicio comunitario:  <small>(Pendiente)</small></p>');
        $this->assertResponseContains($this->alertMessage);
    }

    public function testCourseCardStatusReview(): void
    {
        $this->createStudentStage([
           'student_id' => $this->student->id,
           'stage' => StageField::COURSE,
           'status' => StageStatus::REVIEW,
           'lapse_id' => $this->lapse_id,
        ])->persist();

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('Sin información a mostrar');
        $this->assertResponseContains($this->alertMessage);

        $courseDate = FrozenDate::now();
        StudentCourseFactory::make([
             'student_id' => $this->student->id,
             'date' => $courseDate,
             'exonerated' => false,
             'comment' => 'Comentario de prueba',
         ])->persist();

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('<strong>Realizado: </strong>' . $courseDate);
        $this->assertResponseContains('Comentario de prueba');
        $this->assertResponseContains('Descargar planilla 002');
    }

    public function testCourseCardStatusReviewExonerated(): void
    {
        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::COURSE,
            'status' => StageStatus::REVIEW,
            'lapse_id' => $this->lapse_id,
        ])->persist();

        $courseDate = FrozenDate::now();
        StudentCourseFactory::make([
              'student_id' => $this->student->id,
              'date' => $courseDate,
              'exonerated' => true,
              'comment' => 'Comentario de prueba',
          ])->persist();

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('<strong>Exonerado: </strong>' . $courseDate);
        $this->assertResponseContains('Comentario de prueba');
    }

    public function testCourseCardStatusSuccess(): void
    {
        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::COURSE,
            'status' => StageStatus::SUCCESS,
            'lapse_id' => $this->lapse_id,
        ])->persist();

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('Sin información a mostrar');
        $this->assertResponseContains($this->alertMessage);

        $courseDate = FrozenDate::now();
        StudentCourseFactory::make([
            'student_id' => $this->student->id,
            'date' => $courseDate,
            'exonerated' => false,
            'comment' => 'Comentario de prueba',
        ])->persist();

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('<strong>Realizado: </strong>' . $courseDate);
        $this->assertResponseContains('Comentario de prueba');
        $this->assertResponseNotContains('Descargar planilla 002');
    }

    public function testCourseCardStatusSuccessExonerated(): void
    {
        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::COURSE,
            'status' => StageStatus::SUCCESS,
            'lapse_id' => $this->lapse_id,
        ])->persist();

        $courseDate = FrozenDate::now();
        StudentCourseFactory::make([
            'student_id' => $this->student->id,
            'date' => $courseDate,
            'exonerated' => true,
            'comment' => 'Comentario de prueba',
        ])->persist();

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('<strong>Exonerado: </strong>' . $courseDate);
        $this->assertResponseContains('Comentario de prueba');
        $this->assertResponseNotContains('Descargar planilla 002');
    }

    public function testCourseCardOtherStatuses(): void
    {
        $course = $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::COURSE,
            'status' => StageStatus::IN_PROGRESS,
        ]);
        $courseEntity = $course->persist();

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('Sin información a mostrar');
        $this->assertResponseContains($this->alertMessage);

        $courseEntity->status = StageStatus::FAILED->value;
        $course->getTable()->saveOrFail($courseEntity);

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('Sin información a mostrar');
        $this->assertResponseContains($this->alertMessage);

        $courseEntity->status = StageStatus::LOCKED->value;
        $course->getTable()->saveOrFail($courseEntity);

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('Sin información a mostrar');
        $this->assertResponseContains($this->alertMessage);
    }
}
