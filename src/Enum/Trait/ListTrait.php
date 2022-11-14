<?php
declare(strict_types=1);

namespace App\Enum\Trait;

trait ListTrait
{
    /**
     * @return array
     */
    public static function toList(array $cases = null): array
    {
        $cases = $cases ?? static::cases();

        $output = [];
        foreach ($cases as $case) {
            $output[$case->value] = $case->label();
        }

        return $output;
    }
}
