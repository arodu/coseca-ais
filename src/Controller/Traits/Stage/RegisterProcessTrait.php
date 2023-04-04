<?php

declare(strict_types=1);

namespace App\Controller\Traits\Stage;

use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use Cake\Http\Exception\ForbiddenException;
use Cake\Log\Log;

trait RegisterProcessTrait
{
    protected function processEdit(int $student_id, bool $updateStatus = true): array
    {
        $success = false;

        /** @var \App\Model\Entity\StudentStage $registerStage */
        $registerStage = $this->Students->StudentStages
            ->find('byStudentStage', [
                'student_id' => $student_id,
                'stage' => StageField::REGISTER,
            ])
            ->first();

        if (empty($registerStage) || !$this->Authorization->can($registerStage, 'registerEdit')) {
            throw new ForbiddenException(__('No puede realizar cambios en el registro'));
        }

        $student = $this->Students->findById($student_id)
            ->find('withTenants')
            ->find('withLapses')
            ->contain([
                'StudentData',
                'AppUsers',
            ])
            ->firstOrFail();

        $currentLapse = $student->getCurrentLapse();
        if (empty($currentLapse) || !$this->Authorization->can($currentLapse, 'registerEdit')) {
            throw new ForbiddenException(__('No puede realizar cambios en el registro'));
        }

        debug($student);
        debug($student->getCurrentLapse());
        exit();


        if ($this->request->is(['patch', 'post', 'put'])) {
            try {
                $student = $this->Students->patchEntity($student, $this->request->getData());

                $this->Students->getConnection()->begin();
                $this->Students->saveOrFail($student);
                if ($updateStatus) {
                    $this->Students->StudentStages->updateStatus($registerStage, StageStatus::REVIEW);
                }
                $this->Students->getConnection()->commit();
                $success = true;
                $this->Flash->success(__('The student has been saved.'));
            } catch (\Exception $e) {
                $this->Students->getConnection()->rollback();
                Log::error($e->getMessage());
                $this->Flash->error(__('The student could not be saved. Please, try again.'));
            }
        }

        return compact('success', 'student', 'registerStage');
    }
}
