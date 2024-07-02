<?php
declare(strict_types=1);

namespace App\Controller\Traits\Stage;

use App\Model\Field\AdscriptionStatus;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Log\Log;
use Exception;

trait TrackingProcessTrait
{
    /**
     * @param array $data
     * @return array
     */
    protected function processAdd(array $data = []): array
    {
        $tackingTable = $this->fetchTable('StudentTracking');

        $adscription = $tackingTable->Adscriptions->get($data['student_adscription_id']);
        $success = false;

        if (empty($adscription) || !$this->Authorization->can($adscription, 'addTracking')) {
            throw new ForbiddenException(__('You are not authorized to add an student tracking'));
        }

        $tracking = $tackingTable->newEntity($data);

        try {
            $tackingTable->saveOrFail($tracking);
            $success = true;
            $this->Flash->success(__('The student tracking has been saved.'));
        } catch (Exception $e) {
            $this->Flash->error(__('The student tracking could not be saved. Please, try again.'));
            Log::error($e->getMessage());
        }

        return [
            'success' => $success,
            'adscription' => $adscription,
            'tracking' => $tracking,
        ];
    }

    /**
     * @param int $tracking_id
     * @return array
     */
    protected function processDelete(int $tracking_id): array
    {
        $tackingTable = $this->fetchTable('StudentTracking');

        $tracking = $tackingTable->get($tracking_id, [
            'contain' => ['Adscriptions'],
        ]);
        $adscription = $tracking->adscription;
        $success = false;

        if (!$this->Authorization->can($adscription, 'deleteTracking')) {
            throw new ForbiddenException(__('You are not authorized to delete this student tracking'));
        }

        if ($tackingTable->delete($tracking)) {
            $success = true;
            $this->Flash->success(__('The student tracking has been deleted.'));
        } else {
            $this->Flash->error(__('The student tracking could not be deleted. Please, try again.'));
        }

        return [
            'success' => $success,
            'adscription' => $adscription,
            'tracking' => $tracking,
        ];
    }

    /**
     * @param int|null $student_id
     * @return void
     * @throws \Cake\Http\Exception\NotFoundException
     */
    protected function processCloseStage(?int $student_id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $trackingStage = $this->Students->StudentStages
            ->find('byStudentStage', [
                'student_id' => $student_id,
                'stage' => StageField::TRACKING,
            ])
            ->contain(['Students'])
            ->first();

        if (!$trackingStage) {
            throw new NotFoundException(__('Invalid stage'));
        }

        $result = $this->Authorization->canResult($trackingStage, 'close');
        if (!$result->getStatus()) {
            $this->Flash->error($result->getReason());

            return;
        }

        try {
            $this->Students->getConnection()->begin();

            $this->Students->StudentAdscriptions
                ->updateAll(
                    ['status' => AdscriptionStatus::CLOSED->value],
                    [
                        'student_id' => $student_id,
                        'status IN' => AdscriptionStatus::getOpenedValues(),
                    ]
                );

            $this->Students->StudentStages->updateStatus($trackingStage, StageStatus::REVIEW);

            $this->Students->getConnection()->commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->Students->getConnection()->rollback();
        }
    }

    /**
     * @param int|string|null $student_id
     * @return void
     * @throws \Cake\Http\Exception\NotFoundException
     */
    protected function processValidateStage($student_id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $trackingStage = $this->Students->StudentStages
            ->find('byStudentStage', [
                'student_id' => $student_id,
                'stage' => StageField::TRACKING,
            ])
            ->contain(['Students'])
            ->first();

        if (!$trackingStage) {
            throw new NotFoundException(__('Invalid stage'));
        }

        $result = $this->Authorization->canResult($trackingStage, 'validate');
        if (!$result->getStatus()) {
            $this->Flash->error($result->getReason());

            return;
        }

        try {
            $this->Students->getConnection()->begin();

            $this->Students->StudentStages->updateStatus($trackingStage, StageStatus::SUCCESS);
            $nextStage = $this->Students->StudentStages->createNext($trackingStage);

            if (($nextStage ?? false)) {
                $this->Flash->success(__('The {0} stage has been created.', $nextStage->stage));
            }

            $this->Students->getConnection()->commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->Students->getConnection()->rollback();
        }
    }
}
