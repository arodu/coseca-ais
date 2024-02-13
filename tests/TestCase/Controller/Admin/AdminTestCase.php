<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use App\Model\Field\UserRole;
use App\Test\Factory\CreateDataTrait;
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
    //protected $lapse_id;
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
}
