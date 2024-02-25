<?php
declare(strict_types=1);

namespace App\Model\Behavior;

use App\Utility\FilterTenantUtility;
use ArrayObject;
use Cake\Event\EventInterface;
use Cake\ORM\Behavior;
use Cake\ORM\Query;
use Cake\Utility\Hash;

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
     * @param \Cake\ORM\Query $query
     * @param array $options
     * @return \Cake\ORM\Query
     */
    public function findTenant(Query $query, array $options): Query
    {
        $skipFilterTenant = Hash::get($options, 'skipFilterTenant', false);
        $tenant_list = FilterTenantUtility::read();

        if (
            !$skipFilterTenant
            && !empty($tenant_list)
            && $this->table()->hasField($this->getConfig('field'))
        ) {
            $query = $query->where([
                $this->table()->aliasField($this->getConfig('field')) . ' IN' => $tenant_list,
            ]);
        }

        return $query;
    }
}
