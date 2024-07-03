<?php
declare(strict_types=1);

namespace App\Utility;

use App\Model\Entity\AppUser;
use App\Model\Field\UserRole;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

class FilterTenantUtility
{
    public const TENANT_FILTER_KEY = 'FilterTenant.tenant_ids';

    /**
     * @param \App\Model\Entity\AppUser $user
     * @return array
     */
    public static function getTenantIdsFromDatabase(AppUser $user): array
    {
        $output = [];
        $tenantsTable = TableRegistry::getTableLocator()->get('Tenants');
        if ($user->enumRole()->isGroup(UserRole::GROUP_ROOT)) {
            $output = $tenantsTable
                ->find()
                ->select(['id'])
                ->all()
                ->extract('id')
                ->toList();
        } elseif ($user->enumRole()->isGroup(UserRole::GROUP_STUDENT)) {
            $output = [$user->current_student->tenant_id];
        } else {
            $output = $tenantsTable->TenantFilters
                ->find()
                ->select(['tenant_id'])
                ->where(['user_id' => $user->id])
                ->all()
                ->extract('tenant_id')
                ->toList();
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
        return Router::getRequest()?->getSession()?->read(self::TENANT_FILTER_KEY) ?? [];
    }

    /**
     * @return void
     */
    public static function clear(): void
    {
        Router::getRequest()->getSession()->delete(self::TENANT_FILTER_KEY);
    }

    /**
     * @param \App\Model\Entity\AppUser $user
     * @param int $tenant_id
     * @return void
     */
    public static function add(AppUser $user, int $tenant_id): void
    {
        if ($user->enum('role')->isGroup(UserRole::GROUP_ROOT)) {
            static::update($user);

            return;
        }

        $tenantFiltersTable = TableRegistry::getTableLocator()->get('TenantFilters');
        $tenantFilter = $tenantFiltersTable->newEntity([
            'user_id' => $user->id,
            'tenant_id' => $tenant_id,
        ]);
        $tenantFiltersTable->saveOrFail($tenantFilter);
        static::update($user);
    }

    /**
     * @param \App\Model\Entity\AppUser $user
     * @return void
     */
    public static function update(AppUser $user): void
    {
        $tenantIds = static::getTenantIdsFromDatabase($user);
        static::write($tenantIds);
    }
}
