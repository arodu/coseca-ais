<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Model\Field\AdscriptionStatus;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use Cake\Http\Exception\NotFoundException;
use Cake\I18n\FrozenDate;
use Cake\View\CellTrait;

/**
 * Reports Controller
 */
class ReportsController extends AppAdminController
{

    /**
     * @inheritDoc
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->Tenants = $this->fetchTable('Tenants');
        $this->Students = $this->fetchTable('Students');
    }

    /**
     * @return void
     */
    public function dashboard()
    {
        $this->MenuLte->activeItem('home');
        $activeTenants = $this->Tenants->find('active')
            ->contain([
                'CurrentLapse',
                'Programs'
            ]);

        $activities = $this->Tenants->Lapses->LapseDates->find()
            ->contain([
                'Lapses' => [
                    'Tenants' => [
                        'Programs'
                    ]
                ]
            ])
            ->where([
                'Lapses.tenant_id IN' => $this->Tenants->find('active')->select(['id']),
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

        $this->set(compact('activeTenants', 'activities'));
    }

    /**
     * @param string $tenant_id
     * @return void
     */
    public function tenant(string $tenant_id)
    {
        $currentTab = $this->getRequest()->getQuery('tab', 'general');
        $lapse_id = $this->getRequest()->getQuery('lapse_id', null);

        $tenant = $this->Tenants->find()
            ->where(['Tenants.id' => $tenant_id])
            ->contain(['Programs'])
            ->first();

        if (!$tenant) {
            throw new NotFoundException(__('No se encontró el programa'));
        }

        if ($lapse_id) {
            $lapseSelected = $this->Tenants->Lapses->find()
                ->where([
                    'Lapses.id' => $lapse_id,
                    'Lapses.tenant_id' => $tenant->id,
                ])->first();
        }

        if (!$lapse_id || !$lapseSelected) {
            $lapseSelected = $this->Tenants->Lapses
                ->find('currentLapse', [
                    'tenant_id' => $tenant_id,
                ])
                ->first();
        }

        if (!$lapseSelected) {
            throw new NotFoundException(__('No se encontró el periodo'));
        }

        $lapses = $this->Tenants->Lapses
            ->find('list', [
                'keyField' => 'id',
                'valueField' => 'name',
                'groupField' => 'label_active',
            ])
            ->order(['active' => 'DESC'])
            ->where(['tenant_id' => $tenant->id]);


        $this->set(compact('tenant', 'lapseSelected', 'lapses', 'currentTab'));
    }
}
