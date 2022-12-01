<?php
declare(strict_types=1);

namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Query;
use Cake\ORM\Table;

/**
 * Filter behavior
 */
class FilterBehavior extends Behavior
{
    public const PREFIX = '_s';

    protected array $_filterFields = [];

    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [];

    public function findFilter(Query $query, array $options = []): Query
    {
        $_filter = $this->checkFields($options[self::PREFIX]);

        $query->where($_filter);

        return $query;
    }

    protected function checkFields(array $filter): array
    {
        return array_filter($filter, function ($v, $k) {
            return !empty($v);
        }, ARRAY_FILTER_USE_BOTH);
    }

    public function addFilter()
    {

    }
}
