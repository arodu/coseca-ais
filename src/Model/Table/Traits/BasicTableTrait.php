<?php
declare(strict_types=1);

namespace App\Model\Table\Traits;

use Cake\ORM\Query\SelectQuery;

trait BasicTableTrait
{
    /**
     * @param \Cake\ORM\Query $query query
     * @return \Cake\ORM\Query
     */
    public function findActive(SelectQuery $query): SelectQuery
    {
        return $query->where([
            $this->aliasField('active') => true,
        ]);
    }

    /**
     * @param \Cake\ORM\Query $query
     * @param array $options
     * @return \Cake\ORM\Query
     */
    public function findObjectList(SelectQuery $query, array $options = []): SelectQuery
    {
        $options += [
            'keyField' => $this->getPrimaryKey(),
            'groupField' => null,
        ];

        return $query->formatResults(function ($results) use ($options) {
            /** @var \Cake\Collection\CollectionInterface $results */
            return $results->combine(
                $options['keyField'],
                fn ($item) => $item,
                $options['groupField'],
            );
        });
    }
}
