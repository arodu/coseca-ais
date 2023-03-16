<?php
declare(strict_types=1);

namespace App\Utility;

use Cake\ORM\TableRegistry;

class Tenants
{
    public static function getTenantList()
    {
        return TableRegistry::getTableLocator()
            ->get('Tenants')
            ->find('withPrograms')
            ->find('active')
            ->find('list', ['keyField' => 'id', 'valueField' => 'label', 'groupField' => 'program.area_label']);
    }
}
