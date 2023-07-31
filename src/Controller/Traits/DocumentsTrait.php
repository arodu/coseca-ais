<?php

declare(strict_types=1);

namespace App\Controller\Traits;

use App\Model\Field\StageField;
use Cake\ORM\Locator\LocatorAwareTrait;

trait DocumentsTrait
{
    use LocatorAwareTrait;

    public function initialize(): void
    {
        parent::initialize();
    }

    public function format007(string $student_id = null)
    {
        $adscriptions = $this->Students->StudentAdscriptions->find()
            ->find('withInstitution')
            ->find('withTracking')
            ->find('withStudents')
            ->find('withTutor')
            ->where(['StudentAdscriptions.student_id' => $student_id])
            ->formatResults(function ($results) {
                return $results->map(function ($row) {
                    $row->totalHours = array_reduce($row->student_tracking, function ($carry, $item) { return $carry + $item->hours; }, 0);

                    return $row;
                });
            })
            ->all();

        $this->viewBuilder()->setClassName('CakePdf.Pdf');

        //$validationToken = $this->StudentAdscriptions->createValidationToken($adscription->id);

        $this->set(compact('adscriptions'));
        $this->render('/Documents/format007');
    }

    /**
     * @param int|string $student_id
     * @return void
     */
    public function format009(int|string $student_id = null)
    {
        $this->Students = $this->fetchTable('Students');
        $this->StudentStages = $this->fetchTable('StudentStages');

        $student = $this->Students->find()
            ->find('withAppUsers')
            ->find('withTenants')
            ->where(['Students.id' => $student_id])
            ->contain([
                'PrincipalAdscription' => [
                    'Tutors',
                    'InstitutionProjects' => [
                        'Institutions',
                    ],
                ],
            ])
            ->firstOrFail();

        $endingStage = $this->StudentStages->find('byStudentStage', [
            'student_id' => $student->id,
            'stage' => StageField::ENDING,
        ])->firstOrFail();

        $this->viewBuilder()->setClassName('CakePdf.Pdf');

        $this->set(compact('student', 'endingStage'));
        $this->render('/Documents/format009');
    }
}
