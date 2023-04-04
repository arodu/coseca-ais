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

    protected function processDelete(int $id)
    {
    }
}
