<?php

declare(strict_types=1);

namespace App\Event;

use App\Model\Entity\AppUser;
use App\Model\Field\UserRole;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
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
        /** @var AppUser $user */
        $user = $event->getData('user');

        if ($user->getRole()->isAdminGroup()) {
            return $event->setResult(['_name' => 'admin:home']);
        }

        if ($user->getRole()->isStudentGroup()) {
            return $event->setResult(['_name' => 'student:home']);
        }
    }

    /**
     * @param \Cake\Event\Event $event
     */
    public function afterRegister(Event $event)
    {
        /** @var AppUser $user */
        $user = $event->getData('user');

        if ($user->getRole()->isStudentGroup()) {
            $this->fetchTable('Students')->newRegularStudent($user);
        }
    }
}
