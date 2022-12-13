<?php

declare(strict_types=1);

namespace App\Model\Field;

enum StudentType: string
{
    case REGULAR = 'regular';
    case VALIDATED = 'validated';

    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            static::REGULAR => __('Regular'),
            static::VALIDATED => __('Convalidación'),

            default => __('NaN'),
        };
    }
}
