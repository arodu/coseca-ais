<?php

declare(strict_types=1);

namespace App\Enum\Trait;

trait BasicEnumTrait
{
    /**
     * @param self|array $enum
     * @return bool
     */
    public function is(self|array $enum): bool
    {
        if (is_array($enum)) {
            return in_array($this, $enum, true);
        }

        return $this === $enum;
    }
}
