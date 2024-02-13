<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Student;

use App\Model\Field\AdscriptionStatus;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use Cake\I18n\FrozenDate;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\Utility\Hash;

/**
 * App\Controller\Student\TrackingController Test Case
 *
 * @uses \App\Controller\Student\TrackingController
 */
class TrackingControllerTest extends StudentTestCase
{
    use IntegrationTestTrait;

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\Student\TrackingController::index()
     */
    public function testIndex(): void
    {
        $student = $this->createRegularStudent();
        $this->setAuthSession($student);
        $lapse_id = $this->lapse_id;

        $trackingStage = $this->addRecord('StudentStages', [
            'student_id' => $student->id,
            'stage' => StageField::TRACKING->value,
            'status' => StageStatus::IN_PROGRESS->value,
        ]);

        $lapseDate = $this->getRecordByOptions('LapseDates', [
            'lapse_id' => $lapse_id,
            'stage' => StageField::TRACKING->value,
        ]);

        $this->get('/student/tracking');

        $this->assertResponseOk();
        $this->assertResponseContains('Seguimiento: 2023-1');
        $this->assertResponseContains('tracking-count');
        $this->assertResponseContains('tracking-first-date');
        $this->assertResponseContains('tracking-last-date');
        $this->assertResponseContains('total-hours');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\Student\TrackingController::add()
     */
    public function testAdd(): void
    {
        $student = $this->createRegularStudent();
        $this->setAuthSession($student);
        $lapse_id = $this->lapse_id;
        $trackingStage = $this->addRecord('StudentStages', [
            'student_id' => $student->id,
            'stage' => StageField::TRACKING->value,
            'status' => StageStatus::IN_PROGRESS->value,
        ]);

        $this->get('/student/tracking/add');
        $this->assertResponseError();

        $project = Hash::get($this->institution, 'institution_projects.0');
        $tutor = Hash::get($this->tutors, '0');
        $adscription = $this->addRecord('StudentAdscriptions', [
            'student_id' => $student->id,
            'institution_project_id' => $project->id,
            'tutor_id' => $tutor->id,
            'status' => AdscriptionStatus::OPEN->value,
        ]);

        $this->post('/student/tracking/add', [
            'student_adscription_id' => $adscription->id,
            'date' => \Cake\I18n\Date::now(),
            'hours' => 1,
            'description' => 'Test 1',
        ]);

        $this->assertResponseCode(302);

        $this->get('/student/tracking');
        $this->assertResponseContains('<h5 class="tracking-count description-header">1</h5>');
        $this->assertResponseContains('<h5 class="total-hours description-header">1</h5>');

        $this->post('/student/tracking/add', [
            'student_adscription_id' => $adscription->id,
            'date' => \Cake\I18n\Date::now(),
            'hours' => 6,
            'description' => 'Test 2',
        ]);

        $this->get('/student/tracking');
        $this->assertResponseContains('<h5 class="tracking-count description-header">2</h5>');
        $this->assertResponseContains('<h5 class="total-hours description-header">7</h5>');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\Student\TrackingController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
