<?php

declare(strict_types=1);

namespace App\Controller\Traits;

trait TrackingHandleTrait
{

    protected function handleAdd(array $data)
    {
        $adscription = $this->Tracking->StudentAdscriptions->get($data['student_adscription_id']);

        if (!$this->Authorization->can($adscription, 'addTracking')) {
            $this->Flash->error(__('You are not authorized to add an student tracking.'));
            return $this->redirect(['_name' => 'admin:student:tracking', $adscription->student_id]);
        }

        $tracking = $this->Tracking->newEntity($data);

        if ($this->Tracking->save($tracking)) {
            $success = true;
            $this->Flash->success(__('The student tracking has been saved.'));
        } else {
            $success = false;
            $this->Flash->error(__('The student tracking could not be saved. Please, try again.'));
        }

        return [
            'success' => $success,
            'adscription' => $adscription,
            'tracking' => $tracking,
        ];
    }

    protected function handleDelete(int $id)
    {
    }
}
