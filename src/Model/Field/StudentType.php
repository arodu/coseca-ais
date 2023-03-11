<?php

declare(strict_types=1);

namespace App\Model\Field;

enum StudentType: string
{
    case REGULAR = 'regular';
    case VALIDATED = 'validated';
    case HISTORY = 'history';

    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            static::REGULAR => __('Regular'),
            static::VALIDATED => __('Convalidación'),
            static::HISTORY => __('Historico'),

            default => __('NaN'),
        };
    }
}
