<?php

namespace App\Controller\Admin\Stage;

use App\Controller\AppController;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use Cake\Http\Exception\ForbiddenException;

class ResultsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->StudentStages = $this->fetchTable('StudentStages');
    }


    public function closeStage($student_id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $resultsStage = $this->StudentStages
            ->find('byStudentStage', [
                'student_id' => $student_id,
                'stage' => StageField::RESULTS,
            ])
            ->first();

        if (!$resultsStage) {
            throw new ForbiddenException();
        }

        // @todo verificar que tiene un proyecto por defecto

        $this->StudentStages->updateStatus($resultsStage, StageStatus::SUCCESS);
        $nextStage = $this->StudentStages->createNext($resultsStage);

        if (($nextStage ?? false)) {
            $this->Flash->success(__('The {0} stage has been created.', $nextStage->stage));
        }

        return $this->redirect(['_name' => 'admin:student:view', $student_id]);
    }
}
