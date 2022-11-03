<?php

namespace App\Event;

use App\Model\Field\Users;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use CakeDC\Users\Plugin as UsersPlugin;

class UsersListener implements EventListenerInterface
{
    /**
     * @return string[]
     */
    public function implementedEvents(): array
    {
        return [
            UsersPlugin::EVENT_AFTER_LOGIN => 'afterLogin',
        ];
    }

    /**
     * @param \Cake\Event\Event $event
     */
    public function afterLogin(Event $event)
    {
        $user = $event->getData('user');

        if (in_array($user->role, Users::getAdminRoles())) {
            $event->setResult(['_name' => 'admin:home']);
        }

        if (in_array($user->role, Users::getStudentRoles())) {
            $event->setResult(['_name' => 'student:home']);
        }
    }
}
