<?php
declare(strict_types=1);

namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Query;
use InvalidArgumentException;
/*
    // TenantsTable
    $this->hasOne('CurrentLapse', [
        'className' => 'Lapses',
        'foreignKey' => 'tenant_id',
        'strategy' => 'select',
        'finder' => 'lastElement',
    ]);

    // LapsesTable
    $this->addBehavior('LastElement', [
        'fieldGroup' => 'tenant_id',
        'subQueryConditions' => [
            $this->aliasField('active') => true,
        ],
    ]);
*/

/**
 * LastElement behavior
 */
class LastElementBehavior extends Behavior
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [
        'fieldGroup' => null,
        'filterBy' => 'id',
        'subQuery' => 'subQueryLastElement',
        'subQueryConditions' => [],
    ];

    /**
     * @param \Cake\ORM\Query $query
     * @param array $options
     * @return \Cake\ORM\Query
     */
    public function findLastElement(Query $query, array $options = []): Query
    {
        $subQuery = $this->table()->find($this->getConfig('subQuery'), $options);

        $subQueryConditions = $options['subQueryConditions'] ?? $this->getConfig('subQueryConditions');
        if (!empty($subQueryConditions) && is_array($subQueryConditions)) {
            $subQuery->where($subQueryConditions);
        }

        $query->where([
            $this->table()->aliasField('id') . ' IN' => $subQuery,
        ]);

        return $query;
    }

    /**
     * @param \Cake\ORM\Query $query
     * @param array $options
     * @return \Cake\ORM\Query
     */
    public function findSubQueryLastElement(Query $query, array $options = []): Query
    {
        $fieldGroup = $options['fieldGroup'] ?? $this->getConfig('fieldGroup');
        if (empty($fieldGroup)) {
            throw new InvalidArgumentException('param fieldGroup is necessary');
        }

        $filterBy = $options['filterBy'] ?? $this->getConfig('filterBy');
        if (empty($filterBy)) {
            throw new InvalidArgumentException('param filterBy is necessary');
        }

        $query
            ->select([$filterBy => 'MAX(' . $this->table()->aliasField($filterBy) . ')'])
            ->group([$this->table()->aliasField($fieldGroup)]);

        return $query;
    }
}
