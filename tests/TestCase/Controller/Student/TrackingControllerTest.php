<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Student;

use App\Controller\Student\TrackingController;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use Cake\TestSuite\IntegrationTestTrait;

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
        $this->markTestIncomplete('Not implemented yet.');

        $this->setSession();

        $student = $this->createRegularStudent();
        $lapse_id = $this->lapse_id;

        $this->get('/student/tracking');
        $this->assertResponseError();

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
        $this->markTestIncomplete('Not implemented yet.');
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
