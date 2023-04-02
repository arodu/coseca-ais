<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Student;

use App\Controller\Student\RegisterStageController;
use App\Model\Entity\Student;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Model\Field\StudentType;
use App\Model\Field\UserRole;
use App\Test\Factory\CreateDataTrait;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\Utility\Hash;

/**
 * App\Controller\Student\RegisterStageController Test Case
 *
 * @uses \App\Controller\Student\RegisterStageController
 */
class RegisterStageControllerTest extends StudentTestCase
{
    public function testEditGet(): void
    {
        $student = $this->createRegularStudent();

        $this->addRecord('StudentStages', [
            'student_id' => $student->id,
            'stage' => StageField::REGISTER->value,
            'status' => StageStatus::IN_PROGRESS->value,
        ]);

        $this->get('/student/register-stage/edit');
        $this->assertResponseOk();
    }
}
