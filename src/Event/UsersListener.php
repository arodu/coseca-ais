<?php
declare(strict_types=1);

namespace App\Event;

use App\Model\Field\UserRole;
use App\Utility\FilterTenantUtility;
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
        ];
    }

    /**
     * @param \Cake\Event\Event $event The event object.
     * @return void|\Cake\Event\Event
     */
    public function afterLogin(Event $event)
    {
        /** @var \App\Model\Entity\AppUser $user */
        $user = $event->getData('user');

        FilterTenantUtility::update($user);

        if ($user->enum('role')->isGroup(UserRole::GROUP_ADMIN)) {
            return $event->setResult(['_name' => 'admin:home']);
        }

        if ($user->enum('role')->isGroup(UserRole::GROUP_STUDENT)) {
            return $event->setResult(['_name' => 'student:home']);
        }

        if ($user->enum('role')->isGroup(UserRole::GROUP_MANAGER)) {
            return $event->setResult(['_name' => 'manager:home']);
        }
    }
}
