<?php
declare(strict_types=1);

namespace App\Utility;

use Cake\ORM\Query;
use Cake\ORM\TableRegistry;

class Tenants
{
    /**
     * @return \Cake\ORM\Query
     */
    public static function getTenantList(): Query
    {
        return TableRegistry::getTableLocator()
            ->get('Tenants')
            ->find('active')
            ->find('list');
    }
}
