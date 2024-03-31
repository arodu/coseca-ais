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
    public static function getTenantList(array $options = []): Query
    {
        $options = array_merge([
            'location' => null,
            'area' => null,
            'program' => null,
        ], $options);

        $query = TableRegistry::getTableLocator()
            ->get('Tenants')
            ->find('active')
            ->find('listLabel');

        if ($options['location']) {
            $subQuery = TableRegistry::getTableLocator()->get('Locations')
                ->find()
                ->select(['id'])
                ->where(['Locations.abbr' => $options['location']]);
            $query->where(['Tenants.location_id IN' => $subQuery]);
        }

        if ($options['area']) {
            $areaId = TableRegistry::getTableLocator()->get('Areas')
                ->find()
                ->select(['id'])
                ->where(['Areas.abbr' => $options['area']])
                ->first();
            $subQuery = TableRegistry::getTableLocator()->get('Programs')
                ->find()
                ->select(['id'])
                ->where(['Programs.area_id' => $areaId->id]);
            $query->where(['Tenants.program_id IN' => $subQuery]);
        }

        if ($options['program']) {
            $subQuery = TableRegistry::getTableLocator()->get('Programs')
                ->find()
                ->select(['id'])
                ->where(['Programs.abbr' => $options['program']]);
            $query->where(['Tenants.program_id IN' => $subQuery]);
        }

        return $query;
    }
}
