<?php

declare(strict_types=1);

namespace App\View\Cell;

use App\Model\Entity\StudentStage;
use App\Model\Field\AdscriptionStatus;
use App\Model\Field\StageField;
use Cake\View\Cell;

/**
 * TrackingView cell
 */
class TrackingViewCell extends Cell
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
        $this->Students = $this->fetchTable('Students');
        $this->viewBuilder()->addHelpers([
            'Button',
            'ModalForm',
        ]);
    }

    /**
     * Default display method.
     *
     * @return void
     */
    public function display($student_id, array $urlList = [])
    {
        $student = $this->Students
            ->find('withLapses')
            ->where(['Students.id' => $student_id])
            ->first();

        $trackingStage = $this->Students->StudentStages
            ->find()
            ->contain(['Students'])
            ->where([
                'StudentStages.student_id' => $student_id,
                'StudentStages.stage' => StageField::TRACKING->value,
            ])
            ->first();

        $adscriptions = $this->Students->StudentAdscriptions
            ->find('withInstitution')
            ->find('withTracking')
            ->where([
                'StudentAdscriptions.student_id' => $student_id,
                'StudentAdscriptions.status IN' => AdscriptionStatus::getTrackablesValues(),
            ]);

        $this->set(compact('student', 'adscriptions', 'urlList', 'trackingStage'));
    }

    public function info($student_id)
    {
        $trackingInfo = $this->Students->getStudentTrackingInfo($student_id) ?? [];
        $this->set(compact('trackingInfo'));
    }

    public function actions($student_id, StudentStage $trackingStage = null)
    {
        if (empty($trackingStage)) {
            $trackingStage = $this->Students->StudentStages
                ->find()
                ->contain(['Students'])
                ->where([
                    'StudentStages.student_id' => $student_id,
                    'StudentStages.stage' => StageField::TRACKING->value,
                ])
                ->first();
        }

        $this->set(compact('trackingStage'));
    }
}
