<?php
declare(strict_types=1);

namespace App\View\Cell;

use App\Utility\CacheRequest;
use App\Utility\ReportsUtility;
use Cake\I18n\Date;
use Cake\ORM\ResultSet;
use Cake\View\Cell;

/**
 * Dashboard cell
 */
class DashboardCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array<string, mixed>
     */
    protected array $_validCellOptions = [];

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->Tenants = $this->fetchTable('Tenants');
        $this->Students = $this->fetchTable('Students');
    }

    /**
     * @return void
     */
    public function blocks(): void
    {
        $currentLapses = $this->getCurrentLapses();
        $studentsActives = $this->Students->find()
            ->where([
                'Students.lapse_id IN' => $currentLapses->extract('id')->toArray(),
                'Students.active' => true,
            ]);

        $this->set([
            'currentLapses' => array_unique($currentLapses->extract('name')->toArray()),
            'studentsActives' => $studentsActives->count(),
        ]);
    }

    /**
     * @return void
     */
    public function activeTenants(): void
    {
        $activeTenants = $this->Tenants->find()
            ->where([
                'Tenants.id IN' => $this->getCurrentTenants(),
            ])
            ->contain([
                'CurrentLapse',
                'Programs',
            ]);

        $this->set(compact('activeTenants'));
    }

    /**
     * @return void
     */
    public function events(): void
    {
        $events = $this->Tenants->Lapses->LapseDates->find()
            ->contain([
                'Lapses' => [
                    'Tenants' => [
                        'Programs',
                    ],
                ],
            ])
            ->where([
                'Lapses.tenant_id IN' => $this->getCurrentTenants(),
                'OR' => [
                    'LapseDates.start_date IS NOT' => null,
                    'LapseDates.end_date IS NOT' => null,
                ],
                'OR' => [
                    'LapseDates.start_date >=' => Date::now(),
                    'LapseDates.end_date >=' => Date::now(),
                ],
            ])
            ->order([
                'LapseDates.end_date' => 'DESC',
                'LapseDates.start_date' => 'DESC',
            ]);

        $this->set(compact('events'));
    }

    /**
     * @return void
     */
    public function stages(): void
    {
        $students = $this->Students->find()
            ->find('active')
            ->where([
                'Students.tenant_id IN' => $this->getCurrentTenants(),
                'Students.lapse_id IN' => $this->getCurrentLapses()->extract('id')->toArray(),
            ]);

        $reports = $this->Students->StudentStages
            ->find('report', student_ids: $students->select(['id']))
            ->toArray();

        $this->set([
            'statuses' => ReportsUtility::getStatusList(),
            'stages' => ReportsUtility::getStageList(),
            'reports' => $reports,
        ]);
    }

    /**
     * @return array
     */
    protected function getCurrentTenants(): array
    {
        return CacheRequest::remember('current_tenants', function () {
            return $this->Tenants
                ->find('active')
                ->select(['id'])
                ->all()
                ->extract('id')
                ->toArray();
        });
    }

    /**
     * @return \Cake\ORM\ResultSet
     */
    protected function getCurrentLapses(): ResultSet
    {
        return CacheRequest::remember('current_lapses', function () {
            return $this->Tenants->Lapses
                ->find('lastElement')
                ->where([
                    'Lapses.tenant_id IN' => $this->getCurrentTenants(),
                    'Lapses.active' => true,
                ])
                ->all();
        });
    }
}
