<?php

namespace App\Controller\Admin\Stage;

use App\Controller\AppController;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use Cake\Http\Exception\ForbiddenException;

class EndingsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->StudentStages = $this->fetchTable('StudentStages');
    }


    public function closeStage($student_id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $endingStage = $this->StudentStages
            ->find('byStudentStage', [
                'student_id' => $student_id,
                'stage' => StageField::ENDING,
            ])
            ->first();

        if (!$endingStage) {
            throw new ForbiddenException();
        }

        // @todo verificar que tiene un proyecto por defecto

        $this->StudentStages->updateStatus($endingStage, StageStatus::SUCCESS);

        return $this->redirect(['_name' => 'admin:student:view', $student_id]);
    }
}
