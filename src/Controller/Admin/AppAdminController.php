<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;

class AppAdminController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('CakeLte.MenuLte');
        $this->viewBuilder()->setLayout('CakeLte.default');
    }


    public function closeStudentStage($student_id, StageField $stageField, StageStatus $stageStatus)
    {
        $studentStagesTable = $this->fetchTable('StudentStages');

        $studentStage = $studentStagesTable->find('byStudentStage', [
            'stage' => $stageField,
            'student_id' => $student_id,
        ])->first();

        return $studentStagesTable->close($studentStage, $stageStatus);
    }
}
