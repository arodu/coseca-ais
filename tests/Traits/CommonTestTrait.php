<?php

declare(strict_types=1);

namespace App\Test\Traits;

use App\Model\Entity\AppUser;
use App\Model\Field\AdscriptionStatus;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Test\Factory\AppUserFactory;
use App\Test\Factory\AreaFactory;
use App\Test\Factory\InstitutionFactory;
use App\Test\Factory\InstitutionProjectFactory;
use App\Test\Factory\InterestAreaFactory;
use App\Test\Factory\LapseFactory;
use App\Test\Factory\ProgramFactory;
use App\Test\Factory\StudentAdscriptionFactory;
use App\Test\Factory\StudentFactory;
use App\Test\Factory\StudentStageFactory;
use App\Test\Factory\TenantFactory;
use App\Test\Factory\TutorFactory;
use CakephpFixtureFactories\Factory\BaseFactory;

trait CommonTestTrait
{
    /**
     * @var string
     */
    protected $alertMessage = 'Comuniquese con la coordinación de servicio comunitario para mas información';

    /**
     * @param array $options
     * @param integer $times
     * @return \CakephpFixtureFactories\Factory\BaseFactory
     */
    protected function createUser(array $options = [], int $times = 1): BaseFactory
    {
        return AppUserFactory::make($options, $times);
    }

    /**
     * Set the Auth session
     * 
     * @param AppUser $user
     * @return AppUser
     */
    protected function setAuthSession(AppUser $user): AppUser
    {
        $user = AppUserFactory::find('auth', ['id' => $user->id])->first();
        $this->session(['Auth' => $user]);

        return $user;
    }

    /**
     * Create a program with tenants, interest areas and lapses
     * 
     * example:
     *
     * @param array $options
     * @param integer $times
     * @return \CakephpFixtureFactories\Factory\BaseFactory
     */
    protected function createProgram(array $options = [], int $times = 1): BaseFactory
    {
        $option_lapses = $options['lapses'] ?? [];
        unset($options['lapses']);
        if ($option_lapses instanceof LapseFactory) {
            $lapses = $option_lapses;
        } else {
            $lapses = LapseFactory::make($option_lapses, $option_lapses['times'] ?? 1);
        }

        $option_tenants = $options['tenants'] ?? [];
        unset($options['tenants']);
        if ($option_tenants instanceof TenantFactory) {
            $tenants = $option_tenants;
        } else {
            $tenants = TenantFactory::make($option_tenants, $option_tenants['times'] ?? 1)
                ->with('Locations')
                ->with('Lapses', $lapses);
        }

        $option_interest_areas = $options['interest_areas'] ?? [];
        unset($options['interest_areas']);
        if ($option_interest_areas instanceof InterestAreaFactory) {
            $interest_areas = $option_interest_areas;
        } else {
            $interest_areas = InterestAreaFactory::make($option_interest_areas, $option_interest_areas['times'] ?? 4);
        }

        $option_area = $options['areas'] ?? [];
        unset($options['areas']);
        if ($option_area instanceof AreaFactory) {
            $area = $option_area;
        } else {
            $area = AreaFactory::make($option_area, $option_area['times'] ?? 1);
        }

        $program = ProgramFactory::make($options, $times)
            ->with('Areas', $area)
            ->with('InterestAreas', $interest_areas)
            ->with('Tenants', $tenants);

        return $program;
    }

    /**
     * @param array $options
     * @param integer $times
     * @return \CakephpFixtureFactories\Factory\BaseFactory
     */
    protected function createStudent(array $options = [], int $times = 1): BaseFactory
    {
        if (empty($options['tenant_id'])) {
            throw new \InvalidArgumentException('tenant_id is required');
        }

        if (empty($options['user_id'])) {
            throw new \InvalidArgumentException('user_id is required');
        }

        return StudentFactory::make($options, $times);
    }

    /**
     * @param array $options
     * @param integer $times
     * @return \CakephpFixtureFactories\Factory\BaseFactory
     */
    protected function createInstitution(array $options = [], int $times = 1): BaseFactory
    {
        if (empty($options['tenant_id'])) {
            throw new \InvalidArgumentException('tenant_id is required');
        }

        $project = $options['projects'] ?? [];
        unset($options['projects']);
        if ($project instanceof InstitutionProjectFactory) {
            $projects = $project;
        } else {
            $projects = InstitutionProjectFactory::make($project, $project['times'] ?? 1);
        }

        return InstitutionFactory::make($options, $times)
            ->with('InstitutionProjects', $projects);
    }

    /**
     * @param array $options
     * @param integer $times
     * @return \CakephpFixtureFactories\Factory\BaseFactory
     */
    protected function createTutor(array $options = [], int $times = 1): BaseFactory
    {
        return TutorFactory::make($options, $times);
    }

    /**
     * @param array $options
     * @param integer $times
     * @return \CakephpFixtureFactories\Factory\BaseFactory
     */
    protected function createAdscription(array $options = [], int $times = 1): BaseFactory
    {
        if (empty($options['student_id'])) {
            throw new \InvalidArgumentException('student_id is required');
        }

        if (empty($options['institution_project_id'])) {
            throw new \InvalidArgumentException('institution_project_id is required');
        }

        if (empty($options['tutor_id'])) {
            throw new \InvalidArgumentException('institution_project_id is required');
        }

        if (empty($options['status'])) {
            throw new \InvalidArgumentException('status is required');
        }

        if ($options['status'] instanceof AdscriptionStatus) {
            $options['status'] = $options['status']->value;
        }

        return StudentAdscriptionFactory::make($options, $times);
    }

    protected function createStudentStage(array $options = [], int $times = 1): BaseFactory
    {
        if (empty($options['student_id'])) {
            throw new \InvalidArgumentException('student_id is required');
        }

        if (empty($options['stage'])) {
            throw new \InvalidArgumentException('stage is required');
        }
        if ($options['stage'] instanceof StageField) {
            $options['stage'] = $options['stage']->value;
        }

        if (empty($options['status'])) {
            throw new \InvalidArgumentException('status is required');
        }
        if ($options['status'] instanceof StageStatus) {
            $options['status'] = $options['status']->value;
        }

        return StudentStageFactory::make($options, $times);
    }

    /**
     * @param boolean $log
     * @return void
     */
    protected function debugResponse($log = false)
    {
        if ($log) {
            \Cake\Log\Log::debug((string) $this->_response->getBody());
        } else {
            debug((string) $this->_response->getBody());
        }
    }
}
