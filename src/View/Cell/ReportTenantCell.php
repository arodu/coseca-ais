<?php
declare(strict_types=1);

namespace App\View\Cell;

use App\Model\Entity\Lapse;
use App\Model\Entity\Tenant;
use App\Model\Field\AdscriptionStatus;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use Cake\View\Cell;

/**
 * ReportTenant cell
 */
class ReportTenantCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array<string, mixed>
     */
    protected $_validCellOptions = [];

    public const TAB_GENERAL = 'general';
    public const TAB_PROJECTS = 'projects';
    public const TAB_TUTORS = 'tutors';
    public const TAB_FINISHED = 'finished';

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->Students = $this->fetchTable('Students');
    }

    protected function tabList(): array
    {
        return [
            self::TAB_GENERAL => [
                'label' => __('General'),
            ],
            self::TAB_PROJECTS => [
                'label' => __('Proyectos'),
            ],
            self::TAB_TUTORS => [
                'label' => __('Tutores'),
            ],
            self::TAB_FINISHED => [
                'label' => __('Finalizado'),
            ],
        ];
    }

    /**
     * @param string|null $currentTab
     * @return string
     */
    protected function getCurrentTab(?string $currentTab = null): string
    {
        if (in_array($currentTab, array_keys($this->tabList()), true)) {
            return $currentTab;
        }

        return self::TAB_GENERAL;
    }

    /**
     * @param \App\Model\Entity\Tenant $tenant
     * @param string $currentTab
     * @param \App\Model\Entity\Lapse $lapseSelected
     * @return void
     */
    public function tabs(Tenant $tenant, string $currentTab, Lapse $lapseSelected)
    {
        $tabs = $this->tabList();
        $currentTab = $this->getCurrentTab($currentTab);
        $this->set(compact('tenant', 'currentTab', 'lapseSelected', 'tabs'));
    }

    public function general(Tenant $tenant, Lapse $lapseSelected)
    {
        $students = $this->Students->find()
            ->find('active')
            ->where([
                'Students.tenant_id' => $tenant->id,
                'Students.lapse_id' => $lapseSelected->id,
            ]);

        $studentWithoutLapse = $this->Students->find()
            ->find('active')
            ->where([
                'Students.tenant_id' => $tenant->id,
                'Students.lapse_id IS' => null,
            ]);

        $reports = $this->Students->StudentStages->find()
            ->select([
                'stage' => 'StudentStages.stage',
                'status' => 'StudentStages.status',
                'count' => 'COUNT(StudentStages.id)',
            ])
            ->where([
                'StudentStages.student_id IN' => $students->select(['id']),
            ])
            ->group([
                'StudentStages.stage',
                'StudentStages.status',
            ])
            ->formatResults(function ($results) {
                return $results->combine(
                    function ($row) {
                        return $row['stage'] . '-' . $row['status'];
                    },
                    function ($row) {
                        return $row['count'];
                    }
                );
            })
            ->toArray();

        $this->set(compact('reports', 'studentWithoutLapse'));
    }

    public function projects(Tenant $tenant, Lapse $lapseSelected)
    {
        $students = $this->Students->find()
            ->where([
                'Students.tenant_id' => $tenant->id,
                'Students.lapse_id' => $lapseSelected->id,
            ]);

        $studentAdscriptions = $this->Students->StudentAdscriptions->find()
            ->where([
                'StudentAdscriptions.student_id IN' => $students->select(['id']),
            ])
            ->contain([
                'Students' => [
                    'AppUsers',
                    'LastStage',
                ],
                'Tutors',
            ])
            ->where([
                'StudentAdscriptions.status NOT IN' => [AdscriptionStatus::CANCELLED->value],
            ])
            ->formatResults(function ($results) {
                return $results->combine(
                    'student_id',
                    function ($row) {
                        return $row;
                    },
                    'institution_project_id'
                );
            })
            ->toArray();

        $projects = [];
        if (!empty($studentAdscriptions)) {
            $projects = $this->Students->StudentAdscriptions->InstitutionProjects->find()
                ->where([
                    'InstitutionProjects.id IN' => array_keys($studentAdscriptions),
                ])
                ->contain([
                    'Institutions',
                ])
                ->toArray();
        }

        $this->set(compact('studentAdscriptions', 'projects'));
    }

    public function tutors(Tenant $tenant, Lapse $lapseSelected)
    {
        $this->set(compact('tenant', 'lapseSelected'));
    }

    public function finished(Tenant $tenant, Lapse $lapseSelected)
    {
        $students = $this->Students->find()
            ->where([
                'Students.tenant_id' => $tenant->id,
                'Students.lapse_id' => $lapseSelected->id,
            ]);

        $approvedService = $this->Students->StudentStages->find()
            ->where([
                'StudentStages.student_id IN' => $students->select(['id']),
                'StudentStages.stage' => StageField::ENDING->value,
                'StudentStages.status IN' => [StageStatus::WAITING->value, StageStatus::SUCCESS->value],
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

        $this->set(compact('approvedService'));
    }
}
