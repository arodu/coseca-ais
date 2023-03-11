<?php

declare(strict_types=1);

namespace App\Enum\Trait;

trait BasicEnumTrait
{
    /**
     * @param self $status
     * @return bool
     */
    public function is(self $status): bool
    {
        return $this === $status;
    }
}
