<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\Database\Query;

trait BasicTableTrait
{

    public function findActive(Query $query): Query
    {
        return $query->where(['active' => true]);
    }

}