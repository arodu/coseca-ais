<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use App\Model\Entity\Student;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Model\Field\StudentType;
use App\Model\Field\UserRole;
use App\Test\Factory\CreateDataTrait;
use App\Test\Factory\InstitutionFactory;
use App\Test\Factory\StudentFactory;
use App\Test\Factory\TutorFactory;
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
    //protected $tutors;
    //protected $institution;
    //protected $alertMessage = 'Comuniquese con la coordinación de servicio comunitario para mas información';

    protected function setUp(): void
    {
        parent::setUp();

        $this->enableRetainFlashMessages();
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->program = $this->createProgram()->persist();
        $this->user = $this->createUser(['role' => UserRole::ADMIN->value])->persist();
        $this->tenant_id = Hash::get($this->program, 'tenants.0.id');
        $this->lapse_id = Hash::get($this->program, 'tenants.0.lapses.0.id');
        $this->setDefaultLapseDates($this->lapse_id);
        $this->today = FrozenDate::now();

        //$this->lapse_id = Hash::get($this->program, 'tenants.0.lapses.0.id');
        //$this->setDefaultLapseDates($this->lapse_id);

        //$this->tutors = TutorFactory::make([
        //    'tenant_id' => $this->tenant_id,
        //], 5)->persist();

        //$this->institution = InstitutionFactory::make([
        //    'tenant_id' => $this->tenant_id,
        //])
        //    ->with('InstitutionProjects', [], 5)
        //    ->persist();
    }

    protected function tearDown(): void
    {
        unset($this->program);
        unset($this->user);
        //unset($this->lapse_id);
        unset($this->tenant_id);
        //unset($this->tutors);
        //unset($this->institution);

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
