<?php

namespace App\Event;

use App\Model\Field\Users;
use Cake\Event\EventListenerInterface;
use Cake\ORM\Locator\LocatorAwareTrait;

class UsersListener implements EventListenerInterface
{
    use LocatorAwareTrait;

    /**
     * @return string[]
     */
    public function implementedEvents(): array
    {
        return [
            \CakeDC\Users\Plugin::EVENT_AFTER_LOGIN => 'afterLogin',
        ];
    }

    /**
     * @param \Cake\Event\Event $event
     */
    public function afterLogin(\Cake\Event\Event $event)
    {
        $user = $event->getData('user');
        //your custom logic
        //$this->loadModel('SomeOptionalUserLogs')->newLogin($user);

        if (in_array($user->role, Users::getAdminRoles())) {
            $event->setResult(['_name' => 'admin:home']);
        }

        if (in_array($user->role, Users::getStudentRoles())) {
            // @todo add student_id here
            $event->setResult(['_name' => 'student:home']);
        }
    }
}
