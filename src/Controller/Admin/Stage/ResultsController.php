<?php
declare(strict_types=1);

namespace App\Controller\Admin\Stage;

use App\Controller\AppController;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Response;

class ResultsController extends AppController
{
    /**
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->StudentStages = $this->fetchTable('StudentStages');
    }

    /**
     * @param string|int|null $student_id
     * @return \Cake\Http\Response|null|void
     */
    public function closeStage(int|string|null $student_id = null): Response|null|null
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
