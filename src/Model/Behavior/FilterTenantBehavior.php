<?php
declare(strict_types=1);

namespace App\Model\Behavior;

use App\Utility\FilterTenantUtility;
use ArrayObject;
use Cake\Event\EventInterface;
use Cake\ORM\Behavior;
use Cake\ORM\Query\SelectQuery;
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
    protected array $_defaultConfig = [
        'field' => 'tenant_id',
    ];

    /**
     * @inheritDoc
     */
    public function beforeFind(EventInterface $event, SelectQuery $query, ArrayObject $options, $primary)
    {
        return $query
            ->find('tenant', options: $options->getArrayCopy());
    }

    /**
     * @param \Cake\ORM\Query\SelectQuery $query
     * @param array $options
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findTenant(SelectQuery $query, array $options = []): SelectQuery
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
