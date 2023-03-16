<?php

declare(strict_types=1);

namespace App\Model\Field;

use App\Enum\Trait\BasicEnumTrait;
use App\Enum\Trait\ListTrait;

enum ProgramRegime: string
{
    use ListTrait;
    use BasicEnumTrait;

    case BIANNUAL = 'biannual';
    case QUARTERLY = 'quarterly';
    case ANNUALIZED = 'annualized';

    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            static::BIANNUAL => __('Semestral'),
            static::QUARTERLY => __('Trimestral'),
            static::ANNUALIZED => __('Anualizado'),

            default => __('NaN'),
        };
    }
}
