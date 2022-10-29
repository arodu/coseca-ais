<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;

trait BasicTableTrait
{
    /**
     * @param \Cake\ORM\Query $query query
     * @return \Cake\ORM\Query
     */
    public function findActive(Query $query): Query
    {
        return $query->where([
            $this->aliasField('active') => true,
        ]);
    }
}
