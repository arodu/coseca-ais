<?php

declare(strict_types=1);

namespace App\Controller\Traits\Stage;

use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use Cake\Http\Exception\ForbiddenException;
use Cake\Log\Log;

/**
 * @property \App\Model\Table\StudentsTable $Students
 */
trait RegisterProcessTrait
{
    protected function processEdit(int $student_id, array $options = []): array
    {
        $success = false;

        /** @var \App\Model\Entity\StudentStage $registerStage */
        $registerStage = $this->Students->StudentStages
            ->find('byStudentStage', [
                'student_id' => $student_id,
                'stage' => StageField::REGISTER,
            ])
            ->first();


            debug(__METHOD__);

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

        if ($this->request->is(['patch', 'post', 'put'])) {
            try {
                $this->Students->getConnection()->begin();

                $student = $this->Students->patchEntity($student, $this->request->getData());
                $this->Students->saveOrFail($student);

                if ($options['updateStatus'] ?? false) {
                    $this->Students->StudentStages->updateStatus($registerStage, StageStatus::REVIEW);
                }

                if ($options['validate'] ?? false) {
                    if (!$this->Authorization->can($registerStage, 'registerValidate')) {
                        throw new ForbiddenException(__('No puede realizar cambios en el registro'));
                    }

                    $this->Students->StudentStages->updateStatus($registerStage, StageStatus::SUCCESS);
                    $nextStage = $this->Students->StudentStages->createNext($registerStage);
                }

                $this->Students->getConnection()->commit();
                $success = true;

                $this->Flash->success(__('The student has been saved.'));
                if (($nextStage ?? false)) {
                    $this->Flash->success(__('The {0} stage has been created.', $nextStage->stage));
                }
            } catch (\Exception $e) {
                $success = false;
                Log::error($e->getMessage());
                $this->Students->getConnection()->rollback();
                $this->Flash->error(__('The student could not be saved. Please, try again.'));
            }
        }

        return compact('success', 'student', 'registerStage');
    }
}
