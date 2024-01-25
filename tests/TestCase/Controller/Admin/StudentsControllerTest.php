<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use App\Controller\Admin\StudentsController;
use App\Model\Entity\Student;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Model\Field\StudentType;
use App\Test\Factory\LapseFactory;
use App\Test\Factory\StudentFactory;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Admin\StudentsController Test Case
 *
 * @uses \App\Controller\Admin\StudentsController
 */
class StudentsControllerTest extends AdminTestCase
{
    use IntegrationTestTrait;


    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::index()
     */
    public function testIndex(): void
    {
        $this->get('/admin/students');
        $this->assertResponseCode(302);

        $this->setAuthSession();
        $this->get('/admin/students');
        $this->assertResponseCode(200);

        $this->get('/admin/students');

        $student = $this->createRegularStudent();
        $this->assertResponseCode(200);

        // dd($student->id);

        // $this->assertRedirectContains('/admin/students');

        // dd($student);
        // $this->assertResponseContains($student->name);

        // $lapse_id = $this->lapse_id;

        // $trackingStage = $this->addRecord('StudentStages', [
        //     'student_id' => $student->id,
        //     'stage' => StageField::TRACKING->value,
        //     'status' => StageStatus::IN_PROGRESS->value,
        // ]);

        // $lapseDate = $this->getRecordByOptions('LapseDates', [
        //     'lapse_id' => $lapse_id,
        //     'stage' => StageField::TRACKING->value,
        // ]);

        // $this->get('/student/tracking');

        // $this->assertResponseOk();
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::view()
     */
    public function testView(): void
    {
        $this->setAuthSession();
        $student = $this->createRegularStudent();

        $this->get('/admin/student/view/'. $student->id);
        $this->assertResponseCode(200);

        $this->assertResponseContains($student->name);

    }

    /**
     * Test info method
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::info()
     */
    // public function testInfo(): void
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    /**
     * Test adscriptions method
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::adscriptions()
     */
    // public function testAdscriptions(): void
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    /**
     * Test settings method
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::settings()
     */
    // public function testSettings(): void
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    /**
     * Test tracking method
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::tracking()
     */
    // public function testTracking(): void
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    /**
     * Test prints method
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::prints()
     */
    // public function testPrints(): void
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::add()
     */
    // public function testAdd(): void
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::edit()
     */
    // public function testEdit(): void
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::delete()
     */
    // public function testDelete(): void
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    /**
     * Test changeEmail method
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::changeEmail()
     */
    // public function testChangeEmail(): void
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    /**
     * Test newProgram method
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::newProgram()
     */
    // public function testNewProgram(): void
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    /**
     * Test deactivate method
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::deactivate()
     */
    // public function testDeactivate(): void
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    /**
     * Test reactivate method
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::reactivate()
     */
    // public function testReactivate(): void
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    /**
     * Test bulkActions method
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::bulkActions()
     */
    // public function testBulkActions(): void
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }
}
