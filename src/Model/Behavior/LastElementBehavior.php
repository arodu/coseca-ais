<?php
declare(strict_types=1);

namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Query;
use Cake\ORM\Query\SelectQuery;
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
    protected array $_defaultConfig = [
        'fieldGroup' => null,
        'filterBy' => 'id',
        'subQuery' => 'subQueryLastElement',
        'subQueryConditions' => [],
    ];

    /**
     * @param \Cake\ORM\Query $query
     * @param $options
     * @return \Cake\ORM\Query
     */
    public function findLastElement(SelectQuery $query): SelectQuery
    {
        $options = $query->getOptions();

        $subQuery = $this->table()
            ->find()
            ->applyOptions($options)
            ->find($this->getConfig('subQuery'));

        $subQueryConditions = $options['subQueryConditions'] ?? $this->getConfig('subQueryConditions');
        if (!empty($subQueryConditions) && is_array($subQueryConditions)) {
            $subQuery->where($subQueryConditions);
        }

        return $query->where([
            $this->table()->aliasField('id') . ' IN' => $subQuery,
        ]);
    }

    /**
     * @param \Cake\ORM\Query $query
     * @param array $options
     * @return \Cake\ORM\Query
     */
    public function findSubQueryLastElement(SelectQuery $query): SelectQuery
    {
        $options = $query->getOptions();

        $fieldGroup = $options['fieldGroup'] ?? $this->getConfig('fieldGroup');
        if (empty($fieldGroup)) {
            throw new InvalidArgumentException('param fieldGroup is necessary');
        }

        $filterBy = $options['filterBy'] ?? $this->getConfig('filterBy');
        if (empty($filterBy)) {
            throw new InvalidArgumentException('param filterBy is necessary');
        }

        return $query
            ->select([$filterBy => 'MAX(' . $this->table()->aliasField($filterBy) . ')'])
            ->group([$this->table()->aliasField($fieldGroup)]);
    }
}
