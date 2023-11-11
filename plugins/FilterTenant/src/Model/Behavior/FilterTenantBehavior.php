<?php
declare(strict_types=1);

namespace FilterTenant\Model\Behavior;

use ArrayObject;
use Cake\Event\EventInterface;
use Cake\ORM\Behavior;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use FilterTenant\Utility\FilterTenantUtility;

/**
 * FilterTenant behavior
 */
class FilterTenantBehavior extends Behavior
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [
        'field' => 'tenant_id',
    ];

    /**
     * @inheritDoc
     */
    public function beforeFind(EventInterface $event, Query $query, ArrayObject $options, $primary)
    {
        return $query->find('tenant', $options->getArrayCopy());
    }

    /**
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findTenant(Query $query, array $options): Query
    {
        $skipFilterTenant = Hash::get($options, 'skipFilterTenant', false);

        if (!$skipFilterTenant && $this->table()->hasField($this->getConfig('field'))) {
            $query = $query->where([
                $this->table()->aliasField($this->getConfig('field')) . ' IN' => FilterTenantUtility::read(),
            ]);
        }

        return $query;
    }
}
