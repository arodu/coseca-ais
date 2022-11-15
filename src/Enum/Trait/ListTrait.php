<?php

declare(strict_types=1);

namespace App\Enum\Trait;

trait ListTrait
{
    /**
     * @param array|null $cases
     * @return array
     */
    public static function toListLabel(array $cases = null): array
    {
        $cases = $cases ?? static::cases();

        $output = [];
        foreach ($cases as $case) {
            $output[$case->value] = $case->label();
        }

        return $output;
    }

    /**
     * @param array|null $cases
     * @return array
     */
    public static function toListName(array $cases = null): array
    {
        $cases = $cases ?? static::cases();

        return array_combine(static::values($cases), static::names($cases));
    }

    /**
     * @param array|null $cases
     * @return array
     */
    public static function names(array $cases = null): array
    {
        $cases = $cases ?? static::cases();

        return array_column($cases, 'name');
    }

    /**
     * @param array|null $cases
     * @return array
     */
    public static function values(array $cases = null): array
    {
        $cases = $cases ?? static::cases();

        return array_column($cases, 'value');
    }
}
