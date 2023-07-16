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

    public function format007($adscription_id = null)
    {
        $this->StudentAdscriptions = $this->fetchTable('StudentAdscriptions');

        $adscription = $this->StudentAdscriptions->find()
            ->find('withInstitution')
            ->find('withTracking')
            ->find('withStudents')
            ->find('withTutor')
            ->where(['StudentAdscriptions.id' => $adscription_id])
            ->firstOrFail();

        $this->viewBuilder()->setClassName('CakePdf.Pdf');

        $trackingInfo = $this->StudentAdscriptions->Students->getStudentTrackingInfoByAdscription([$adscription->id]);
        $validationToken = $this->StudentAdscriptions->createValidationToken($adscription->id);

        $this->set(compact('adscription', 'trackingInfo', 'validationToken'));
        $this->render('/Documents/format007');
    }

    public function format009($student_id = null)
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
