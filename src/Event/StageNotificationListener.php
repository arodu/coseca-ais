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

    /**
     * @param \Cake\Event\Event $event The event object.
     * @return void
     */
    public function emailManage(Event $event)
    {
    }

    /**
     * @return void
     */
    public function emailOnRegister()
    {
    }

    /**
     * @return void
     */
    public function emailOnAdscriptionProject()
    {
    }

    /**
     * @return void
     */
    public function emailOnAdscriptionValidation()
    {
    }

    /**
     * @return void
     */
    public function emailOnFinishSuccess()
    {
    }
}
