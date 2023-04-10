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
    case ANNUALIZED_5 = 'annualized_5';
    case ANNUALIZED_6 = 'annualized_6';

    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            static::BIANNUAL => __('Semestral'),
            static::QUARTERLY => __('Trimestral'),
            static::ANNUALIZED_5 => __('Anualizado (5 años)'),
            static::ANNUALIZED_6 => __('Anualizado (6 años)'),
            default => __('NaN'),
        };
    }

    public function formLabel(): string
    {
        return match ($this) {
            static::BIANNUAL => __('Semestre'),
            static::QUARTERLY => __('Trimestre'),
            static::ANNUALIZED_5 => __('Año'),
            static::ANNUALIZED_6 => __('Año'),
            default => __('NaN'),
        };
    }

    public function maxLevel(): int
    {
        return match ($this) {
            static::BIANNUAL => 10,
            static::QUARTERLY => 15,
            static::ANNUALIZED_5 => 5,
            static::ANNUALIZED_6 => 6,
            default => 0,
        };
    }
}
