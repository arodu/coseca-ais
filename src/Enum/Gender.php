<?php
declare(strict_types=1);

namespace App\Enum;

use App\Enum\Trait\ListTrait;

enum Gender: string
{
    use ListTrait;

    case FEMALE = 'F';
    case MALE = 'M';

    /**
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            static::FEMALE => __('Femenino'),
            static::MALE => __('Masculino'),

            default => __('NaN'),
        };
    }
}
