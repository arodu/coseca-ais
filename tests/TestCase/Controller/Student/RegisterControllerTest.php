<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Student;

use App\Model\Entity\Student;
use App\Model\Entity\StudentStage;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use Cake\I18n\FrozenDate;
use Cake\TestSuite\IntegrationTestTrait;

/**
 * App\Controller\Student\RegisterController Test Case
 *
 * @uses \App\Controller\Student\RegisterController
 */
class RegisterControllerTest extends StudentTestCase
{
    use IntegrationTestTrait;
    
    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\Student\RegisterController::edit()
     */
    /*
    public function testEditResponseCodeError(): void
    {
        $this->setAuthSession();
        $student = $this->createRegularStudent();

        $this->get('/studen/register');
        $this->assertResponseCode(302);

        $registerStage = $this->addRecord('StudentStages', [
            'student_id' => $student->id,
            'stage' => StageField::REGISTER->value,
            'status' => StageStatus::WAITING->value,
        ]);       
        $this->get('/student/register');
        $this->assertResponseCode(302);

        $this->updateRecord($registerStage, ['status' => StageStatus::REVIEW->value]);
        $this->get('/student/register');
        $this->assertResponseCode(302);

        $this->updateRecord($registerStage, ['status' => StageStatus::SUCCESS->value]);
        $this->get('/student/register');
        $this->assertResponseCode(302);

        $this->updateRecord($registerStage, ['status' => StageStatus::FAILED->value]);
        $this->get('/student/register');
        $this->assertResponseCode(302);

        $this->updateRecord($registerStage, ['status' => StageStatus::LOCKED->value]);
        $this->get('/student/register');
        $this->assertResponseCode(302);
    }
    */

    public function testEditResponseCodeOk(): void
    {
        $this->markTestSkipped('This test is not ready yet.');

        $this->setAuthSession();

        $student = $this->createRegularStudent();
        $lapse_id = $this->lapse_id;

        $this->addRecord('StudentStages', [
            'student_id' => $student->id,
            'stage' => StageField::REGISTER->value,
            'status' => StageStatus::IN_PROGRESS->value,
        ]);

        $lapseDate = $this->getRecordByOptions('LapseDates', [
            'lapse_id' => $lapse_id,
            'stage' => StageField::REGISTER->value,
        ]);

        $start_date = FrozenDate::now()->subDays(1);
        $end_date = FrozenDate::now()->addDays(1);
        $this->updateRecord($lapseDate, compact('start_date', 'end_date'));

        $this->get('/student/register');
        //debug($registerStage);
        //debug($student);
        //debug($this->_response);

        $this->assertResponseOk();



    }
}
