<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Student;

use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
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
     * @return void
     * @uses \App\Controller\Student\RegisterController::edit()
     */
    public function testEditResponseCodeError(): void
    {
        $student = $this->createRegularStudent();
        $this->setAuthSession($student);

        $this->get('/student/register');
        $this->assertResponseCode(403);

        $registerStage = $this->addRecord('StudentStages', [
            'student_id' => $student->id,
            'stage' => StageField::REGISTER->value,
            'status' => StageStatus::WAITING->value,
        ]);
        $this->get('/student/register');
        $this->assertResponseCode(403);

        $this->updateRecord($registerStage, ['status' => StageStatus::REVIEW->value]);
        $this->get('/student/register');
        $this->assertResponseCode(403);

        $this->updateRecord($registerStage, ['status' => StageStatus::SUCCESS->value]);
        $this->get('/student/register');
        $this->assertResponseCode(403);

        $this->updateRecord($registerStage, ['status' => StageStatus::FAILED->value]);
        $this->get('/student/register');
        $this->assertResponseCode(403);

        $this->updateRecord($registerStage, ['status' => StageStatus::LOCKED->value]);
        $this->get('/student/register');
        $this->assertResponseCode(403);
    }

    public function testEditWithCurrentLapseError(): void
    {
        $student = $this->createRegularStudent();
        $this->setAuthSession($student);
        $lapse_id = $this->lapse_id;

        $registerStage = $this->addRecord('StudentStages', [
            'student_id' => $student->id,
            'stage' => StageField::REGISTER->value,
            'status' => StageStatus::IN_PROGRESS->value,
        ]);

        $this->get('/student/register');
        $this->assertResponseCode(403);

        $lapseDate = $this->getRecordByOptions('LapseDates', [
            'lapse_id' => $lapse_id,
            'stage' => StageField::REGISTER->value,
        ]);

        $start_date = \Cake\I18n\Date::now()->subDays(4);
        $end_date = \Cake\I18n\Date::now()->subDays(2);
        $this->updateRecord($lapseDate, compact('start_date', 'end_date'));
        $this->get('/student/register');
        $this->assertResponseCode(403);

        $start_date = \Cake\I18n\Date::now()->addDays(2);
        $end_date = \Cake\I18n\Date::now()->addDays(4);
        $this->updateRecord($lapseDate, compact('start_date', 'end_date'));
        $this->get('/student/register');
        $this->assertResponseCode(403);

        $start_date = \Cake\I18n\Date::now()->subDays(2);
        $end_date = \Cake\I18n\Date::now()->addDays(2);
        $this->updateRecord($lapseDate, compact('start_date', 'end_date'));
        $this->get('/student/register');
        $this->assertResponseCode(200);
    }

    public function testEditResponseCodeOk(): void
    {
        $student = $this->createRegularStudent();
        $this->setAuthSession($student);
        $lapse_id = $this->lapse_id;

        $registerStage = $this->addRecord('StudentStages', [
            'student_id' => $student->id,
            'stage' => StageField::REGISTER->value,
            'status' => StageStatus::IN_PROGRESS->value,
        ]);

        $lapseDate = $this->getRecordByOptions('LapseDates', [
            'lapse_id' => $lapse_id,
            'stage' => StageField::REGISTER->value,
        ]);

        $start_date = \Cake\I18n\Date::now()->subDays(2);
        $end_date = \Cake\I18n\Date::now()->addDays(2);
        $this->updateRecord($lapseDate, compact('start_date', 'end_date'));
        $this->get('/student/register');
        $this->assertResponseCode(200);

        $this->assertResponseContains('input type="text" name="app_user[first_name]"');
        $this->assertResponseContains('input type="text" name="app_user[last_name]"');
        $this->assertResponseContains('input type="number" name="app_user[dni]"');
        $this->assertResponseContains('select name="student_data[gender]"');
        $this->assertResponseContains('input type="tel" name="student_data[phone]"');
        $this->assertResponseContains('input type="text" name="student_data[address]"');
        $this->assertResponseContains('select name="student_data[current_semester]"');
        $this->assertResponseContains('input type="number" name="student_data[uc]"');
        $this->assertResponseContains('select name="student_data[interest_area_id]"');
        $this->assertResponseContains('textarea name="student_data[observations]"');
    }

    public function testEditSubmitDataOk(): void
    {
        $this->markTestSkipped();

        [
            'registerStage' => $registerStage,
            'student' => $student,
        ] = $this->setRegisterStageOk();

        $this->post('/student/register', []);
        $this->assertRedirect(['_name' => 'student:home']);

        $this->post('/student/register', [
            'app_user' => [
                'first_name' => 'test_first_name',
                'last_name' => 'test_last_name',
                'dni' => '1234567',
            ],
            'student_data' => [
                'gender' => 'F',
                'uc' => '100',
                'interest_area_id' => '2',
                'observations' => 'Lorem',
            ],
        ]);
        $this->assertRedirect(['_name' => 'student:home']);

        $studentResult = $this->fetchTable('Students')->get($student->id, contain: [
            'AppUsers',
            'StudentData',
        ]);

        $this->assertEquals('test_first_name', $studentResult->first_name);
        $this->assertEquals('test_last_name', $studentResult->last_name);
        $this->assertEquals('1234567', $studentResult->dni);
        $this->assertEquals('F', $studentResult->student_data->gender);
        $this->assertEquals('100', $studentResult->student_data->uc);
        $this->assertEquals('2', $studentResult->student_data->interest_area_id);
        $this->assertEquals('Lorem', $studentResult->student_data->observations);

        //$registerStageResult = $this->getRecord('StudentStages', $registerStage->id);
        //dd($registerStageResult);
    }

    public function testEditStudentTryingValidate(): void
    {
        [
            'student' => $student,
        ] = $this->setRegisterStageOk();

        $this->post('/student/register', [
            'app_user' => [
                'first_name' => 'test_first_name',
                'last_name' => 'test_last_name',
                'dni' => '1234567',
            ],
            'student_data' => [
                'gender' => 'F',
                'uc' => '100',
                'interest_area_id' => '2',
                'observations' => 'Lorem',
            ],
        ]);
        $this->assertRedirect(['_name' => 'student:home']);
    }

    public function testEditSubmitDataEmptyValues(): void
    {
        $this->markTestIncomplete();
    }

    protected function setRegisterStageOk(): array
    {
        $student = $this->createRegularStudent();
        $this->setAuthSession($student);
        $lapse_id = $this->lapse_id;

        $registerStage = $this->addRecord('StudentStages', [
            'student_id' => $student->id,
            'stage' => StageField::REGISTER->value,
            'status' => StageStatus::IN_PROGRESS->value,
        ]);

        $lapseDate = $this->getRecordByOptions('LapseDates', [
            'lapse_id' => $lapse_id,
            'stage' => StageField::REGISTER->value,
        ]);

        $start_date = \Cake\I18n\Date::now()->subDays(2);
        $end_date = \Cake\I18n\Date::now()->addDays(2);
        $this->updateRecord($lapseDate, compact('start_date', 'end_date'));
        $this->get('/student/register');
        $this->assertResponseCode(200);

        return compact('student', 'registerStage', 'lapseDate');
    }
}
