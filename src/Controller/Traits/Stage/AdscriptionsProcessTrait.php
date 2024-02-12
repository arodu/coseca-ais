<?php
declare(strict_types=1);

namespace App\Controller\Traits\Stage;

use App\Model\Field\AdscriptionStatus;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Utility\Stages;
use Cake\Http\Exception\ForbiddenException;

trait AdscriptionsProcessTrait
{
    /**
     * @param string $status
     * @param int|string $id
     * @return \App\Model\Entity\StudentAdscription
     */
    protected function processChangeStatus($status, $id)
    {
        $this->Adscriptions = $this->fetchTable('StudentAdscriptions');

        $adscription = $this->Adscriptions->get($id);

        if ($status == AdscriptionStatus::VALIDATED->value && !$this->Authorization->can($adscription, 'validate')) {
            throw new ForbiddenException('No tiene permisos para validar la adscripción');
        }

        $adscription->status = $status;
        if ($this->Adscriptions->save($adscription)) {
            $this->Flash->success(__('The student_adscription has been saved.'));
        } else {
            $this->Flash->error(__('The student_adscription could not be saved. Please, try again.'));
        }

        if ($status == AdscriptionStatus::OPEN->value) {
            Stages::closeStudentStage($adscription->student_id, StageField::ADSCRIPTION, StageStatus::SUCCESS);
        }

        return $adscription;
    }
}
