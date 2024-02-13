<?php
declare(strict_types=1);

namespace App\Utility;

use Cake\ORM\Query;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\TableRegistry;

class Tenants
{
    /**
     * @return \Cake\ORM\Query\SelectQuery
     */
    public static function getTenantList(): SelectQuery
    {
        return TableRegistry::getTableLocator()
            ->get('Tenants')
            ->find('active')
            ->find('list');
    }
}
