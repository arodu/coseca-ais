<?php

declare(strict_types=1);

namespace App\Model\Field;

use App\Enum\Trait\BasicEnumTrait;
use App\Enum\Trait\ListTrait;

enum ProgramArea: string
{
    use ListTrait;
    use BasicEnumTrait;

    case AIS = 'ais';

    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            static::AIS => __('AIS'),
            default => __('NaN'),
        };
    }
}
