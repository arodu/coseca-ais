<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller\Student;

use App\Model\Field\AdscriptionStatus;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Model\Field\StudentType;
use Cake\I18n\FrozenDate;
use Cake\Utility\Hash;

/**
 * App\Controller\Student\DashboardController Test Case
 *
 * @uses \App\Controller\Student\DashboardController
 */
class DashboardControllerTest extends StudentTestCase
{
    public function testStudentTypeRegular(): void
    {
        $this->setAuthSession();
        $student = $this->createRegularStudent();

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('Registro');
        $this->assertResponseContains('Taller');
        $this->assertResponseContains('Adscripción');
        $this->assertResponseContains('Seguimiento');
        $this->assertResponseContains('Resultados');
        $this->assertResponseContains('Conclusión');
        $this->assertResponseNotContains('Convalidación');

        $this->updateRecord($student, ['type' => StudentType::VALIDATED->value]);
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('Registro');
        $this->assertResponseNotContains('Taller');
        $this->assertResponseNotContains('Adscripción');
        $this->assertResponseNotContains('Seguimiento');
        $this->assertResponseNotContains('Resultados');
        $this->assertResponseNotContains('Conclusión');
        $this->assertResponseContains('Convalidación');
    }

    public function testRegisterCardStatusInProgress(): void
    {
        $this->setAuthSession();
        $student = $this->createRegularStudent(['lapse_id' => null]);
        $lapse_id = $this->lapse_id;

        $this->addRecord('StudentStages', [
            'student_id' => $student->id,
            'stage' => StageField::REGISTER->value,
            'status' => StageStatus::IN_PROGRESS->value,
        ]);

        // whitout lapse dates
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('No existe fecha de registro');
        $this->assertResponseContains($this->alertMessage);

        $lapseDate = $this->getRecordByOptions('LapseDates', [
            'lapse_id' => $lapse_id,
            'stage' => StageField::REGISTER->value,
        ]);

        // with lapse dates in pass
        $start_date = FrozenDate::now()->subDays(4);
        $end_date = FrozenDate::now()->subDays(3);
        $this->updateRecord($lapseDate, compact('start_date', 'end_date'));
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('Ya pasó el período de registro');
        $this->assertResponseContains($this->alertMessage);

        // with lapse dates in future
        $start_date = FrozenDate::now()->addDays(3);
        $end_date = FrozenDate::now()->addDays(4);
        $this->updateRecord($lapseDate, compact('start_date', 'end_date'));
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains(__('Fecha de registro: {0}', $lapseDate->show_dates));
        $this->assertResponseContains($this->alertMessage);

        // with lapse dates in progress
        $start_date = FrozenDate::now()->subDays(1);
        $end_date = FrozenDate::now()->addDays(1);
        $this->updateRecord($lapseDate, compact('start_date', 'end_date'));
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('Formulario de registro');
    }

    public function testRegisterCardStatusReview(): void
    {
        $this->setAuthSession();
        $student = $this->createRegularStudent();
        $this->addRecord('StudentStages', [
            'student_id' => $student->id,
            'stage' => StageField::REGISTER->value,
            'status' => StageStatus::REVIEW->value,
        ]);

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('En espera de revisión de documentos.');
        $this->assertResponseContains($this->alertMessage);
    }

    public function testRegisterCardStatusSuccess(): void
    {
        $this->setAuthSession();
        $student = $this->createRegularStudent();
        $this->addRecord('StudentStages', [
            'student_id' => $student->id,
            'stage' => StageField::REGISTER->value,
            'status' => StageStatus::SUCCESS->value,
        ]);

        $this->get('/student');
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
        $this->setAuthSession();
        $student = $this->createRegularStudent();

        $stageRegistry = $this->addRecord('StudentStages', [
            'student_id' => $student->id,
            'stage' => StageField::REGISTER->value,
            'status' => StageStatus::WAITING->value,
        ]);

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('Sin información a mostrar');
        $this->assertResponseContains($this->alertMessage);

        $this->updateRecord($stageRegistry, ['status' => StageStatus::FAILED->value]);
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('Sin información a mostrar');
        $this->assertResponseContains($this->alertMessage);

        $this->updateRecord($stageRegistry, ['status' => StageStatus::LOCKED->value]);
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('Sin información a mostrar');
        $this->assertResponseContains($this->alertMessage);
    }

    public function testCourseCardStatusWaiting(): void
    {
        $this->setAuthSession();
        $lapse_id = $this->lapse_id;
        $student = $this->createRegularStudent();
        $this->addRecord('StudentStages', [
            'student_id' => $student->id,
            'stage' => StageField::COURSE->value,
            'status' => StageStatus::WAITING->value,
        ]);

        $lapseDate = $this->getRecordByOptions('LapseDates', [
            'lapse_id' => $lapse_id,
            'stage' => StageField::COURSE->value,
        ]);

        // whitout lapse dates
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('En espera de la fecha del taller de Servicio Comunitario');
        $this->assertResponseContains($this->alertMessage);

        // with lapse dates in pass
        $start_date = FrozenDate::now()->subDays(4);
        $this->updateRecord($lapseDate, compact('start_date'));
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('Fecha del taller de servicio comunitario: ' . $start_date . ' <small>(Caducado)</small>');
        $this->assertResponseContains($this->alertMessage);

        // with lapse dates in future
        $start_date = FrozenDate::now()->addDays(4);
        $this->updateRecord($lapseDate, compact('start_date'));
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('Fecha del taller de servicio comunitario: ' . $start_date . ' <small>(Pendiente)</small>');
        $this->assertResponseContains($this->alertMessage);

        // with lapse dates in progress
        $start_date = FrozenDate::now();
        $this->updateRecord($lapseDate, compact('start_date'));
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('Fecha del taller de servicio comunitario: ' . $start_date . ' <small>(En Progreso)</small>');
        $this->assertResponseContains($this->alertMessage);
    }

    public function testCourseCardStatusSuccess(): void
    {
        $this->setAuthSession();
        $student = $this->createRegularStudent();
        $this->addRecord('StudentStages', [
            'student_id' => $student->id,
            'stage' => StageField::COURSE->value,
            'status' => StageStatus::SUCCESS->value,
        ]);

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('Sin información a mostrar');
        $this->assertResponseContains($this->alertMessage);

        $courseDate = FrozenDate::now();
        $this->addRecord('StudentCourses', [
            'student_id' => $student->id,
            'date' => $courseDate,
            'comment' => 'Comentario de prueba',
        ]);

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('<strong>Fecha del Taller: </strong>' . $courseDate);
        $this->assertResponseContains('Comentario de prueba');
    }

    public function testCourseCardOtherStatuses(): void
    {
        $this->setAuthSession();
        $student = $this->createRegularStudent();
        $stage = $this->addRecord('StudentStages', [
            'student_id' => $student->id,
            'stage' => StageField::COURSE->value,
            'status' => StageStatus::IN_PROGRESS->value,
        ]);

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('Sin información a mostrar');
        $this->assertResponseContains($this->alertMessage);

        $this->updateRecord($stage, ['status' => StageStatus::REVIEW->value]);
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('Sin información a mostrar');
        $this->assertResponseContains($this->alertMessage);

        $this->updateRecord($stage, ['status' => StageStatus::FAILED->value]);
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('Sin información a mostrar');
        $this->assertResponseContains($this->alertMessage);

        $this->updateRecord($stage, ['status' => StageStatus::LOCKED->value]);
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('Sin información a mostrar');
        $this->assertResponseContains($this->alertMessage);
    }

    public function testAdscriptionCardStatusWaiting(): void
    {
        $this->setAuthSession();
        $student = $this->createRegularStudent();
        $this->addRecord('StudentStages', [
            'student_id' => $student->id,
            'stage' => StageField::ADSCRIPTION->value,
            'status' => StageStatus::WAITING->value,
        ]);

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('El estudiante no tiene proyectos adscritos');
        $this->assertResponseContains($this->alertMessage);
        $this->assertResponseNotContains('Sin información a mostrar');
    }

    public function testAdscriptionCardStatusInProgress(): void
    {
        $this->setAuthSession();
        $student = $this->createRegularStudent();
        $this->addRecord('StudentStages', [
            'student_id' => $student->id,
            'stage' => StageField::ADSCRIPTION->value,
            'status' => StageStatus::IN_PROGRESS->value,
        ]);

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('El estudiante no tiene proyectos adscritos');
        $this->assertResponseContains($this->alertMessage);
        $this->assertResponseNotContains('Sin información a mostrar');

        $project = Hash::get($this->institution, 'institution_projects.0');
        $tutor = Hash::get($this->tutors, '0');
        $adscription = $this->addRecord('StudentAdscriptions', [
            'student_id' => $student->id,
            'institution_project_id' => $project->id,
            'tutor_id' => $tutor->id,
            'status' => AdscriptionStatus::PENDING->value,
        ]);
        $project_label_name = __('{0}: {1}', $this->institution->name, $project->name);

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains($project_label_name);
        $this->assertResponseContains('<span class="badge badge-warning ">Pendiente</span>');
        $this->assertResponseContains('<dd class="col-sm-8">' . $this->institution->name . '</dd>');
        $this->assertResponseContains('<dd class="col-sm-8">' . $this->institution->contact_person . '</dd>');
        $this->assertResponseContains('<dd class="col-sm-8">' . $this->institution->contact_phone . '</dd>');
        $this->assertResponseContains('<dd class="col-sm-8">' . $this->institution->contact_email . '</dd>');
        $this->assertResponseContains('<dd class="col-sm-8">' . $project->name . '</dd>');
        $this->assertResponseContains('<dd class="col-sm-8">' . $tutor->name . '</dd>');
        $this->assertResponseContains('<dd class="col-sm-8">' . $tutor->phone . '</dd>');
        $this->assertResponseContains('<dd class="col-sm-8">' . $tutor->email . '</dd>');

        $this->updateRecord($adscription, ['status' => AdscriptionStatus::OPEN->value]);
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains($project_label_name);
        $this->assertResponseContains('<span class="badge badge-success ">Abierto</span>');
        $this->assertResponseNotContains('Planilla de adscripción');

        $this->updateRecord($adscription, ['status' => AdscriptionStatus::CLOSED->value]);
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains($project_label_name);
        $this->assertResponseContains('<span class="badge badge-danger ">Cerrado</span>');
        $this->assertResponseNotContains('Planilla de adscripción');

        $this->updateRecord($adscription, ['status' => AdscriptionStatus::VALIDATED->value]);
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains($project_label_name);
        $this->assertResponseContains('<span class="badge badge-primary ">Validado</span>');
        $this->assertResponseNotContains('Planilla de adscripción');

        $this->updateRecord($adscription, ['status' => AdscriptionStatus::CANCELLED->value]);
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseNotContains($project_label_name);
        $this->assertResponseNotContains($project->name);
    }

    public function testTrackingCardStatusInProgress(): void
    {
        $this->setAuthSession();
        $student = $this->createRegularStudent();
        $this->addRecord('StudentStages', [
            'student_id' => $student->id,
            'stage' => StageField::TRACKING->value,
            'status' => StageStatus::IN_PROGRESS->value,
        ]);

        // whitout lapse dates
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('El estudiante no tiene proyectos adscritos');
        $this->assertResponseContains($this->alertMessage);

        $project = Hash::get($this->institution, 'institution_projects.0');
        $tutor = Hash::get($this->tutors, '0');
        $adscription = $this->addRecord('StudentAdscriptions', [
            'student_id' => $student->id,
            'institution_project_id' => $project->id,
            'tutor_id' => $tutor->id,
            'status' => AdscriptionStatus::OPEN->value,
        ]);

        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('<h5 class="tracking-count description-header">0</h5>');
        $this->assertResponseContains('<h5 class="tracking-first-date description-header"><code>N/A</code></h5>');
        $this->assertResponseContains('<h5 class="tracking-last-date description-header"><code>N/A</code></h5>');
        $this->assertResponseContains('<h5 class="total-hours description-header">0</h5>');
        $this->assertResponseContains('Registro de actividades');
        $this->assertResponseNotContains('Planilla de actividades');

        $first_date = FrozenDate::now()->subDays(4);
        $record[0] = $this->addRecord('StudentTracking', [
            'student_adscription_id' => $adscription->id,
            'date' => $first_date,
            'hours' => 4,
            'description' => 'test',
        ]);
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('<h5 class="tracking-count description-header">' . 1 . '</h5>');
        $this->assertResponseContains('<h5 class="tracking-first-date description-header">' . $first_date . '</h5>');
        $this->assertResponseContains('<h5 class="tracking-last-date description-header">' . $first_date . '</h5>');
        $this->assertResponseContains('<h5 class="total-hours description-header">' . 4 . '</h5>');
        $this->assertResponseContains('Registro de actividades');
        $this->assertResponseNotContains('Planilla de actividades');

        $last_date = FrozenDate::now()->subDays(3);
        $record[1] = $this->addRecord('StudentTracking', [
            'student_adscription_id' => $adscription->id,
            'date' => $last_date,
            'hours' => 4,
            'description' => 'test',
        ]);
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('<h5 class="tracking-count description-header">' . 2 . '</h5>');
        $this->assertResponseContains('<h5 class="tracking-first-date description-header">' . $first_date . '</h5>');
        $this->assertResponseContains('<h5 class="tracking-last-date description-header">' . $last_date . '</h5>');
        $this->assertResponseContains('<h5 class="total-hours description-header">' . 8 . '</h5>');
        $this->assertResponseContains('Registro de actividades');
        $this->assertResponseNotContains('Planilla de actividades');

        $last_date = FrozenDate::now()->subDays(1);
        $record[2] = $this->addRecord('StudentTracking', [
            'student_adscription_id' => $adscription->id,
            'date' => $last_date,
            'hours' => 4,
            'description' => 'test',
        ]);
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('<h5 class="tracking-count description-header">' . 3 . '</h5>');
        $this->assertResponseContains('<h5 class="tracking-first-date description-header">' . $first_date . '</h5>');
        $this->assertResponseContains('<h5 class="tracking-last-date description-header">' . $last_date . '</h5>');
        $this->assertResponseContains('<h5 class="total-hours description-header">' . 12 . '</h5>');
        $this->assertResponseContains('Registro de actividades');
        $this->assertResponseNotContains('Planilla de actividades');

        $this->deleteRecord($record[1]);
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('<h5 class="tracking-count description-header">' . 2 . '</h5>');
        $this->assertResponseContains('<h5 class="tracking-first-date description-header">' . $first_date . '</h5>');
        $this->assertResponseContains('<h5 class="tracking-last-date description-header">' . $last_date . '</h5>');
        $this->assertResponseContains('<h5 class="total-hours description-header">' . 8 . '</h5>');
        $this->assertResponseContains('Registro de actividades');
        $this->assertResponseNotContains('Planilla de actividades');

        $first_date = $last_date;
        $this->deleteRecord($record[0]);
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('<h5 class="tracking-count description-header">' . 1 . '</h5>');
        $this->assertResponseContains('<h5 class="tracking-first-date description-header">' . $first_date . '</h5>');
        $this->assertResponseContains('<h5 class="tracking-last-date description-header">' . $last_date . '</h5>');
        $this->assertResponseContains('<h5 class="total-hours description-header">' . 4 . '</h5>');
        $this->assertResponseContains('Registro de actividades');
        $this->assertResponseNotContains('Planilla de actividades');

        $last_date = FrozenDate::now();
        $record[3] = $this->addRecord('StudentTracking', [
            'student_adscription_id' => $adscription->id,
            'date' => $last_date,
            'hours' => 120,
            'description' => 'test',
        ]);
        $this->get('/student');
        $this->assertResponseOk();
        $this->assertResponseContains('<h5 class="tracking-count description-header">' . 2 . '</h5>');
        $this->assertResponseContains('<h5 class="tracking-first-date description-header">' . $first_date . '</h5>');
        $this->assertResponseContains('<h5 class="tracking-last-date description-header">' . $last_date . '</h5>');
        $this->assertResponseContains('<h5 class="total-hours description-header">' . 124 . '</h5>');
        $this->assertResponseContains('Registro de actividades');
        $this->assertResponseContains('Planilla de actividades');
    }

    public function testResultsCardStatusWaiting(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testResultsCardStatusSuccess(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testEndingCardStatusWaiting(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testEndingCardStatusSuccess(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
