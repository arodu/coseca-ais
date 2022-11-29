<?php

declare(strict_types=1);

namespace App\Model\Table\Traits;

use Cake\ORM\Query;
use InvalidArgumentException;

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

    /**
     * @param \Cake\ORM\Query $query query
     * @return \Cake\ORM\Query
     */
    public function findLastElement(Query $query, array $options = []): Query
    {
        if (empty($options['fieldGroup'])) {
            throw new InvalidArgumentException('param fieldGroup is necessary');
        }

        if (empty($options['filterBy'])) {
            $options['filterBy'] = 'id';
        }

        $subQuery = $this->find()
            ->select([$options['filterBy'] => 'MAX(' . $this->aliasField($options['filterBy']) . ')'])
            ->group([$this->aliasField($options['fieldGroup'])]);

        if (!empty($options['onlyActive']) && $options['onlyActive']) {
            $subQuery = $subQuery->find('active');
        }

        $query->where([
            $this->aliasField('id') . ' IN'  => $subQuery,
        ]);

        return $query;
    }
}
