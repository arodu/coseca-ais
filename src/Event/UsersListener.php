<?php

namespace App\Event;

use App\Model\Field\UserRole;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Log\Log;
use Cake\ORM\Locator\LocatorAwareTrait;
use CakeDC\Users\Plugin as UsersPlugin;

class UsersListener implements EventListenerInterface
{
    use LocatorAwareTrait;

    /**
     * @return string[]
     */
    public function implementedEvents(): array
    {
        return [
            UsersPlugin::EVENT_AFTER_LOGIN => 'afterLogin',
            UsersPlugin::EVENT_AFTER_REGISTER => 'afterRegister',
        ];
    }

    /**
     * @param \Cake\Event\Event $event
     */
    public function afterLogin(Event $event)
    {
        $user = $event->getData('user');

        if (in_array($user->role, UserRole::getAdminGroup())) {
            return $event->setResult(['_name' => 'admin:home']);
        }

        if (in_array($user->role, UserRole::getStudentGroup())) {
            return $event->setResult(['_name' => 'student:home']);
        }
    }

    /**
     * @param \Cake\Event\Event $event
     */
    public function afterRegister(Event $event)
    {
        $user = $event->getData('user');

        if (in_array($user->role, UserRole::getStudentGroup())) {
            $this->fetchTable('Students')->newRegularStudent($user);
        }
    }
}
