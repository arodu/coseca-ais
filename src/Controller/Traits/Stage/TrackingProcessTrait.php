<?php

declare(strict_types=1);

namespace App\Controller\Traits\Stage;

use Cake\Http\Exception\ForbiddenException;

trait TrackingProcessTrait
{

    protected function processAdd(array $data = [])
    {
        $tackingTable = $this->fetchTable('StudentTracking');

        $adscription = $tackingTable->Adscriptions->get($data['student_adscription_id']);
        $success = false;

        if (empty($adscription) || !$this->Authorization->can($adscription, 'addTracking')) {
            throw new ForbiddenException(__('You are not authorized to add an student tracking'));
        }

        $tracking = $tackingTable->newEntity($data);

        if ($tackingTable->save($tracking)) {
            $success = true;
            $this->Flash->success(__('The student tracking has been saved.'));
        } else {
            $this->Flash->error(__('The student tracking could not be saved. Please, try again.'));
        }

        return [
            'success' => $success,
            'adscription' => $adscription,
            'tracking' => $tracking,
        ];
    }

    protected function processDelete(int $tracking_id)
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
}
