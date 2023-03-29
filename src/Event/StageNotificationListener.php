<?php

declare(strict_types=1);

namespace App\Event;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;

class StageNotificationListener implements EventListenerInterface
{
    /**
     * @return string[]
     */
    public function implementedEvents(): array
    {
        return [
            'StageNotification.emailManage' => 'emailManage',
            'StageNotification.adscriptionValidation' => 'emailOnAdscriptionValidation',
        ];
    }

    public function emailManage(Event $event)
    {
    }

    public function emailOnRegister()
    {
    }

    public function emailOnAdscriptionProject()
    {
    }

    public function emailOnAdscriptionValidation()
    {
    }

    public function emailOnFinishSuccess()
    {
    }
}
