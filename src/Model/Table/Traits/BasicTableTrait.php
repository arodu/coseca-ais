<?php

declare(strict_types=1);

namespace App\Model\Table\Traits;

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

    public function findObjectList(Query $query, array $options = []): Query
    {
        $options += [
            'keyField' => $this->getPrimaryKey(),
            'groupField' => null,
        ];

        return $query->formatResults(function ($results) use ($options) {
            /** @var \Cake\Collection\CollectionInterface $results */
            return $results->combine(
                $options['keyField'],
                fn ($item) => ($item),
                $options['groupField'],
            );
        });
    }
}
