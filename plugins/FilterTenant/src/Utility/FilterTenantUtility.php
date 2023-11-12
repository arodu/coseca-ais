<?php

declare(strict_types=1);

namespace FilterTenant\Utility;

use App\Model\Entity\AppUser;
use App\Model\Field\UserRole;
use Cake\Cache\Cache;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Routing\Router;

class FilterTenantUtility
{
    const TENANT_IDS_CACHE_KEY = 'tenant_ids_';
    const TENANT_FILTER_KEY = 'FilterTenant.tenant_ids';

    use LocatorAwareTrait;

    /**
     * @param AppUser $user
     * @return array
     */
    public function getTenantIds(AppUser $user): array
    {
        return Cache::remember(self::TENANT_IDS_CACHE_KEY . $user->id, function () use ($user) {
            return $this->getTenantIdsFromDatabase($user);
        });
    }

    /**
     * @param AppUser $user
     * @return void
     */
    public function clearCache(AppUser $user): void
    {
        Cache::delete(self::TENANT_IDS_CACHE_KEY . $user->id);
    }

    /**
     * @param AppUser $user
     * @return array
     */
    public function getTenantIdsFromDatabase(AppUser $user): array
    {
        $output = [];
        $tenantsTable = $this->fetchTable('Tenants');
        if ($user->getRole()->inGroup(UserRole::GROUP_ROOT)) {
            $output = $tenantsTable
                ->find('list', [
                    'keyField' => 'id',
                    'valueField' => 'id',
                    'skipFilterTenant' => true,
                ])
                ->toArray();
        } else {
            $output = $tenantsTable->TenantFilters
                ->find('list', [
                    'keyField' => 'tenant_id',
                    'valueField' => 'tenant_id',
                ])
                ->where([
                    'user_id' => $user->id,
                ])
                ->toArray();
        }

        return $output ?? [];
    }

    /**
     * @param array $tenant_ids
     * @return void
     */
    public static function write(array $tenant_ids): void
    {
        Router::getRequest()->getSession()->write(self::TENANT_FILTER_KEY, $tenant_ids);
    }

    /**
     * @return array
     */
    public static function read(): array
    {
        return Router::getRequest()->getSession()->read(self::TENANT_FILTER_KEY, []);
    }

    /**
     * @return void
     */
    public static function clear(): void
    {
        Router::getRequest()->getSession()->delete(self::TENANT_FILTER_KEY);
    }
}
