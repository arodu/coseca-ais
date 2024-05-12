<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller\Student;

use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Model\Field\UserRole;
use App\Test\Traits\CommonTestTrait;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\Utility\Hash;

/**
 * App\Controller\Student\DashboardEndingController Test Case
 */
class DashboardEndingController extends TestCase
{
    use IntegrationTestTrait;
    use CommonTestTrait;

    protected $program;
    protected $user;
    protected $student;
    protected $institution;
    protected $tenant;

    protected function setUp(): void
    {
        parent::setUp();

        $this->program = $this->createProgram()->persist();
        $this->tenant = Hash::get($this->program, 'tenants.0');
        $this->user = $this->createUser(['role' => UserRole::STUDENT])->persist();
        $this->student = $this
            ->createStudent([
                'tenant_id' => $this->tenant->id,
                'user_id' => $this->user->id,
            ])
            ->persist();
        $this->institution = $this->createInstitution(['tenant_id' => $this->tenant->id])->persist();

        $this->user = $this->setAuthSession($this->user);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->program);
        unset($this->user);
        unset($this->student);
        unset($this->institution);
        unset($this->tenant);
    }

    public function testWithoutStatus(): void
    {
        $this->get('/student');

        $this->assertResponseOk();
        $this->assertResponseContains(__('Conclusión'));
        $this->assertResponseContains('<i class="fas fa-lock fa-fw mr-1 ending"></i>');
    }

    public function testStatusWaiting(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testStatusWaitingWithOutAdscription(): void
    {
        $this->createStudentStage([
            'student_id' => $this->student->id,
            'stage' => StageField::ENDING,
            'status' => StageStatus::WAITING,
        ])->persist();

        $this->get('/student');

        $this->assertResponseOk();
        $this->assertResponseContains(__('Conclusión'));
        $this->assertResponseContains('<i class="fas fa-pause fa-fw mr-1 ending"></i>');
        $this->assertResponseContains('<span class="badge badge-light">En espera</span>');
        $this->assertResponseContains(__('Ha ocurrido un problema en la consolidación de los documentos'));
        $this->assertResponseContains($this->alertMessage);
    }

    public function testStatusInProgress(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testStatusReview(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testStatusSuccess(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testStatusFailed(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testStatusLocked(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
