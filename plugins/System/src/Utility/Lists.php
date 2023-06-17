<?php

declare(strict_types=1);

namespace System\Utility;

use Cake\Cache\Cache;
use Cake\ORM\TableRegistry;

class Lists
{
    /**
     * @param string $repository
     * @param string|null $field
     * @param integer|string|null $reference
     * @return array
     */
    public static function get(string $repository, string $field = null, int|string $reference = null): array
    {
        $cacheKey = 'sys_actions_' . $repository . '_' . $field . '_' . $reference;
        return Cache::remember($cacheKey, function () use ($repository, $field, $reference) {
            $table = TableRegistry::getTableLocator()->get($repository);

            if (empty($reference) || empty($field)) {
                return $table->find('list')->toArray() ?? [];
            }

            return $table->find('list')->where([$table->aliasField($field) => $reference])->toArray() ?? [];
        });
    }

    /**
     * @return array
     */
    public static function states(): array
    {
        return static::get('System.States');
    }

    /**
     * @param integer|string|null $state_id
     * @return array
     */
    public static function citites(int|string $state_id = null): array
    {
        return static::get('System.cities', 'state_id', $state_id);
    }

    /**
     * @param integer|string|null $state_id
     * @return array
     */
    public static function municipalities(int|string $state_id = null): array
    {
        return static::get('System.Municipalities', 'state_id', $state_id);
    }

    /**
     * @param integer|string|null $municipalitiy_id
     * @return array
     */
    public static function parishes(int|string $municipalitiy_id = null): array
    {
        return static::get('System.Parishes', 'municipality_id', $municipalitiy_id);
    }
}
