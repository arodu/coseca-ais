<?php

declare(strict_types=1);

namespace App\View\Cell;

use App\Utility\CacheRequest;
use Cake\I18n\FrozenDate;
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
    protected $_validCellOptions = [];

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

    public function blocks()
    {
        $currentLapses = $this->Tenants->Lapses
            ->find('lastElement')
            ->where([
                'Lapses.tenant_id IN' => $this->getCurrentTenants(),
                'Lapses.active' => true,
            ])
            ->order([
                'Lapses.name' => 'DESC',
            ]);

        $studentsActives = $this->Students->find()
            ->where([
                'Students.lapse_id IN' => $currentLapses->extract('id')->toArray(),
                'Students.active' => true,
            ]);

        //$lastStage = $this->Tenants->Students->StudentStages
        //    ->find('lastElement')
        //    ->where([
        //        'StudentStages.lapse_id' => $currentLapse->id,
        //    ])
        //    ->firstOrFail();
        //


        //debug($currentLapses->extract('tenant_id')->toArray());
        //exit();

        $this->set([
            'currentLapses' => array_unique($currentLapses->extract('name')->toArray()),
            'studentsActives' => $studentsActives->count(),
        ]);
    }

    public function activeTenants()
    {
        $activeTenants = $this->Tenants->find()
            ->where([
                'Tenants.id IN' => $this->getCurrentTenants(),
            ])
            ->contain([
                'CurrentLapse',
                'Programs'
            ]);

        $this->set(compact('activeTenants'));
    }

    public function events()
    {
        $events = $this->Tenants->Lapses->LapseDates->find()
            ->contain([
                'Lapses' => [
                    'Tenants' => [
                        'Programs'
                    ]
                ]
            ])
            ->where([
                'Lapses.tenant_id IN' => $this->getCurrentTenants(),
                'OR' => [
                    'LapseDates.start_date IS NOT' => null,
                    'LapseDates.end_date IS NOT' => null,
                ],
                'OR' => [
                    'LapseDates.start_date >=' => FrozenDate::now(),
                    'LapseDates.end_date >=' => FrozenDate::now(),
                ],
            ])
            ->order([
                'LapseDates.end_date' => 'DESC',
                'LapseDates.start_date' => 'DESC',
            ]);

        $this->set(compact('events'));
    }

    protected function getCurrentTenants(): array
    {
        return CacheRequest::remember('current_tenants', function () {
            return $this->Tenants
                ->find('active')
                ->select(['id'])
                ->extract('id')
                ->toArray();
        });
    }
}
