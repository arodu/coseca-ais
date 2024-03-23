<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use App\Model\Entity\Student;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Model\Field\StudentType;
use App\Model\Field\UserRole;
use App\Test\Factory\CreateDataTrait;
use App\Test\Factory\LapseFactory;
use App\Test\Factory\LocationFactory;
use App\Test\Factory\ProgramFactory;
use App\Test\Factory\StudentFactory;
use App\Test\Factory\TenantFactory;
use Cake\I18n\FrozenDate;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\Utility\Hash;

abstract class AdminTestCase extends TestCase
{
    use IntegrationTestTrait;
    use CreateDataTrait;

    protected $program;
    protected $tenant_id;
    protected $user;
    protected $lapse_id;
    protected $today;
    protected $tenant;

    protected function setUp(): void
    {
        parent::setUp();

        $this->enableRetainFlashMessages();
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->user = $this->createUser(['role' => UserRole::ADMIN->value])->persist();

        $tenant = TenantFactory::make()
            ->with(
                'Programs',
                ProgramFactory::make()->with('Areas')
            )
            ->with('Locations', LocationFactory::make())
            ->with('TenantFilters', TenantFactory::make(['user_id' => $this->user->id]))
            ->with('Lapses', LapseFactory::make())
            ->persist();

        $this->tenant = $tenant;

        $this->tenant_id = $tenant->id;
        $this->program = $tenant->program;
        $this->lapse_id = $tenant->lapses[0]->id;
        $this->setDefaultLapseDates($this->lapse_id);
        $this->today = FrozenDate::now();
    }

    protected function tearDown(): void
    {
        unset($this->tenant);
        unset($this->program);
        unset($this->tenant_id);
        unset($this->user);
        unset($this->lapse_id);
        unset($this->today);

        parent::tearDown();
    }

    protected function setAuthSession($user = null)
    {
        $user = $user ?? $this->user;

        $this->session(['Auth' => $user]);
    }

    protected function createRegularStudent(array $options = []): Student
    {
        $options = array_merge([
            'type' => StudentType::REGULAR->value,
            'user_id' => $this->user->id,
            'tenant_id' => $this->tenant_id,
            'lapse_id' => $this->lapse_id,
        ], $options);

        $interest_area_key = rand(0, count($this->program->interest_areas) - 1);

        return $this->createStudent($options)
            ->with('StudentData', [
                'interest_area_id' => $this->program->interest_areas[$interest_area_key]->id,
            ])
            ->persist();
    }

    protected function getResponseContainsForUrl($url, $id, $contains)
    {
        $this->get($url . $id);
        $this->assertResponseContains($contains);
        $this->assertResponseCode(200);
    }

    protected function getUserStudentCreated($program)
    {
        $user = $this->createUser(['role' => UserRole::STUDENT->value]);

        return StudentFactory::make([
            'type' => StudentType::REGULAR->value,
            'lapse_id' => $this->lapse_id,
        ])
            ->with('StudentStages', [
                [
                    'stage' => StageField::REGISTER->value,
                    'status' => StageStatus::IN_PROGRESS->value,
                ],
                [
                    'stage' => StageField::COURSE->value,
                    'status' => StageStatus::IN_PROGRESS->value,
                ],
            ])
            ->with('Tenants', $program->tenants[0])
            ->with('AppUsers', $user)
            ->persist();
    }
}
