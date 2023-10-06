<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use Cake\Event\EventInterface;

/**
 * Reports Controller
 */
class ReportsController extends AppAdminController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Tenants = $this->fetchTable('Tenants');
        $this->Students = $this->fetchTable('Students');
    }

    public function dashboard()
    {
        $this->MenuLte->activeItem('home');
        $activeTenants = $this->Tenants->find('active')
            ->contain([
                'CurrentLapse',
                'Programs'
            ])
            //->cache('active_tenants')
        ;

        $this->set(compact('activeTenants'));

        // emergency
        $sanJuan = 1;
        $lapse20231 = $this->Students->Lapses->find()
            ->where([
                'Lapses.name' => '2023-1',
                'Lapses.tenant_id' => $sanJuan,
            ]);
        $students = $this->Students->find()
            ->where([
                'Students.tenant_id' => $sanJuan,
                'Students.lapse_id IN' => $lapse20231->select(['id']),
            ]);
        $cursoAprovado = $this->Students->StudentStages->find()
            ->where([
                'StudentStages.student_id IN' => $students->select(['id']),
                'StudentStages.stage' => StageField::COURSE->value,
                'StudentStages.status' => StageStatus::SUCCESS->value
            ]);

        $this->set(compact('cursoAprovado'));
        

        $servicioAprovado = $this->Students->StudentStages->find()
            ->where([
                'StudentStages.student_id IN' => $students->select(['id']),
                'StudentStages.stage' => StageField::ENDING->value,
                'StudentStages.status' => StageStatus::WAITING->value,
            ])
            ->contain([
                'Students' => [
                    'AppUsers',
                    'PrincipalAdscription' => [
                        'InstitutionProjects' => [
                            'Institutions',
                        ],
                        'Tutors',
                    ],
                ],
            ]);

        $this->set(compact('servicioAprovado'));

        //debug($servicioAprovado->toArray());

        //exit();
    }

    public function tenant(string $tenant_id, string $lapse_id)
    {

    }

}
