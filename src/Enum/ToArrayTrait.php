<?php
declare(strict_types=1);

namespace App\Enum;

trait ToArrayTrait
{
    /**
     * @return array
     */
    public static function toArray(): array
    {
        $output = [];
        foreach (static::cases() as $case) {
            $output[$case->value] = $case->label();
        }

        return $output;
    }
}
