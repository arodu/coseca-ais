<?php

declare(strict_types=1);

namespace FilterTenant\Utility;

use App\Model\Entity\AppUser;
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\ORM\Locator\LocatorAwareTrait;

class FilterTenantUtility
{
    const TENANT_IDS_CACHE_KEY = 'tenant_ids_';
    const TENANT_FILTER_KEY = 'FilterTenant.tenant_ids';

    use LocatorAwareTrait;

    public function getTenantIds(AppUser $user): array
    {
        return Cache::remember(self::TENANT_IDS_CACHE_KEY . $user->id, function () use ($user) {
            return $this->getTenantIdsFromDatabase($user);
        });
    }

    public function clearCache(AppUser $user): void
    {
        Cache::delete(self::TENANT_IDS_CACHE_KEY . $user->id);
    }

    public function getTenantIdsFromDatabase($user): array
    {
        $output = [];
        $tenantsTable = $this->fetchTable('Tenants');
        if ($user->is_superuser) {
            $output = $tenantsTable
                ->find('list', [
                    'keyField' => 'id',
                    'valueField' => 'id',
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

    public static function write($tenant_ids): void
    {
        Configure::write(self::TENANT_FILTER_KEY, $tenant_ids);
    }

    public static function read(): array
    {
        return Configure::read(self::TENANT_FILTER_KEY) ?? [];
    }


}
