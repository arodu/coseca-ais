<?php
declare(strict_types=1);

namespace App\Event;

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
            UsersPlugin::EVENT_AFTER_REGISTER => 'afterRegister',
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

        $filterTenantUtility = new FilterTenantUtility();
        $tenant_ids = $filterTenantUtility->getTenantIdsFromDatabase($user);
        FilterTenantUtility::write($tenant_ids);

        if ($user->enumRole()->isAdminGroup()) {
            return $event->setResult(['_name' => 'admin:home']);
        }

        if ($user->enumRole()->isStudentGroup()) {
            return $event->setResult(['_name' => 'student:home']);
        }
    }

    /**
     * @param \Cake\Event\Event $event
     * @return void
     */
    public function afterRegister(Event $event)
    {
        /** @var \App\Model\Entity\AppUser $user */
        $user = $event->getData('user');

        if ($user->enumRole()->isStudentGroup()) {
            $this->fetchTable('Students')->newRegularStudent($user);
        }
    }
}
