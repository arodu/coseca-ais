<?php
declare(strict_types=1);

namespace App\Controller\Traits;

use App\Model\Field\AdscriptionStatus;
use App\Model\Field\StageField;
use Cake\ORM\Locator\LocatorAwareTrait;

trait DocumentsTrait
{
    use LocatorAwareTrait;

    /**
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
    }

    /**
     * @param string|int|null $student_id
     * @return void
     */
    public function format007(?string $student_id = null): void
    {
        $student = $this->Students->find()
            ->find('withTenants')
            ->find('withAppUsers')
            ->find('withLapses')
            ->where(['Students.id' => $student_id])
            ->first();

        $adscriptions = $this->Students->StudentAdscriptions->find()
            ->find('withInstitution')
            ->find('withTracking')
            ->find('withTutor')
            ->where([
                'StudentAdscriptions.student_id' => $student_id,
                'StudentAdscriptions.status IN' => AdscriptionStatus::getPrintValues(),
            ])
            ->formatResults(function ($results) {
                return $results->map(function ($row) {
                    $row->totalHours = array_reduce(
                        $row->student_tracking,
                        function ($carry, $item) {
                            return $carry + $item->hours;
                        },
                        0
                    );

                    return $row;
                });
            })
            ->all();

        $this->viewBuilder()->setClassName('CakePdf.Pdf');

        //$validationToken = $this->StudentAdscriptions->createValidationToken($adscription->id);

        $this->set(compact('adscriptions', 'student'));
        $this->render('/Documents/format007');
    }

    /**
     * @param string|int|null $student_id
     * @return void
     */
    public function format009(?string $student_id = null): void
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
