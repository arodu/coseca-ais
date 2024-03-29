<?php
declare(strict_types=1);

namespace App\Controller\Admin\Stage;

use App\Controller\AppController;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use Cake\Http\Exception\NotFoundException;

class EndingsController extends AppController
{
    /**
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->StudentStages = $this->fetchTable('StudentStages');
        $this->Students = $this->fetchTable('Students');
    }

    /**
     * @param int|string|null $student_id
     * @return \Cake\Http\Response|null|void
     */
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
            throw new NotFoundException(__('No se encontró la etapa de conclusiones.'));
        }

        $student = $this->Students->get($student_id, [
            'contain' => ['PrincipalAdscription'],
        ]);

        if (!$student->principal_adscription) {
            throw new NotFoundException(__('El estudiante no tiene un proyecto principal.'));
        }

        $this->StudentStages->updateStatus($endingStage, StageStatus::SUCCESS);

        return $this->redirect(['_name' => 'admin:student:view', $student_id]);
    }
}
