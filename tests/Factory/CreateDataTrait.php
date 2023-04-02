<?php

declare(strict_types=1);

namespace App\Test\Factory;

use App\Model\Entity\StudentStage;
use App\Model\Field\StageField;
use App\Model\Field\UserRole;
use Cake\I18n\FrozenDate;
use Cake\ORM\Locator\LocatorAwareTrait;

trait CreateDataTrait
{
    use LocatorAwareTrait;

    protected function createProgram(array $options = [], int $times = 1)
    {
        $option_lapses = $options['lapses'] ?? [];
        unset($options['lapses']);
        $lapses = LapseFactory::make($option_lapses, $option_lapses['times'] ?? 1);

        $option_tenants = $options['tenants'] ?? [];
        unset($options['tenants']);
        $tenants = TenantFactory::make($option_tenants, $option_tenants['times'] ?? 1)
            ->with('Lapses', $lapses);

        $option_interest_areas = $options['interest_areas'] ?? [];
        unset($options['interest_areas']);
        $interest_areas = InterestAreaFactory::make($option_interest_areas, $option_interest_areas['times'] ?? 6);

        return ProgramFactory::make($options ?? [], $times)
            ->with('Tenants', $tenants)
            ->with('InterestAreas', $interest_areas);
    }

    protected function createInstitution(array $options = [], bool $persist = true)
    {
        if (empty($options['tenant_id'])) {
            throw new \InvalidArgumentException('tenant_id is required');
        }

        // logic here

        return [
            'institution' => null,
            'institution_project' => null,
        ];
    }

    protected function createStudent(array $options = [], int $times = 1)
    {
        if (empty($options['tenant_id'])) {
            throw new \InvalidArgumentException('tenant_id is required');
        }

        if (empty($options['user_id'])) {
            throw new \InvalidArgumentException('user_id is required');
        }

        return StudentFactory::make($options ?? [], $times);
    }

    protected function createUser(array $options = [], int $times = 1)
    {
        return AppUserFactory::make($options ?? [], $times);
    }

    protected function createStudentStage(array $options = [], int $times = 1)
    {
        if (empty($options['student_id'])) {
            throw new \InvalidArgumentException('student_id is required');
        }

        return StudentStageFactory::make($options ?? [], $times);
    }

    protected function updateStudentStage(StudentStage $studentStage): StudentStage
    {
        return $this->fetchTable('StudentStages')->saveOrFail($studentStage);
    }

    protected function setDefaultLapseDates(int $lapse_id)
    {
        return $this->fetchTable('LapseDates')->saveDefaultDates($lapse_id);
    }

    protected function changeLapseDate(int $lapse_id, StageField $stageField, FrozenDate $startDate, ?FrozenDate $endDate = null)
    {
        $LapseDates = $this->fetchTable('LapseDates');

        $lapseDate = $LapseDates->find()
            ->where([
                'lapse_id' => $lapse_id,
                'stage' => $stageField->value,
            ])
            ->first();

        $lapseDate->start_date = $startDate;
        $lapseDate->end_date = $endDate;

        return $LapseDates->saveOrFail($lapseDate);
    }

    protected function createStudentCourse(array $options = [], int $times = 1)
    {
        return StudentCourseFactory::make($options ?? [], $times);
    }
}
