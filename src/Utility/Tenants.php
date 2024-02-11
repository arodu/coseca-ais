<?php
declare(strict_types=1);

namespace App\Utility;

use Cake\ORM\TableRegistry;

class Tenants
{
    /**
     * @return array
     */
    public static function getTenantList(): array
    {
        return TableRegistry::getTableLocator()
            ->get('Tenants')
            ->find('active')
            ->find('list')
            ?? [];
    }
}
