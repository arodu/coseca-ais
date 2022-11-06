<?php
declare(strict_types=1);

namespace App\Model\Field;

use Cake\ORM\TableRegistry;

class Tenants
{
    public static function getTenantList()
    {
        return TableRegistry::getTableLocator()
            ->get('Tenants')
            ->find('list')
            ->find('active');
    }
}