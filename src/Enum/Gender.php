<?php
declare(strict_types=1);

namespace App\Enum;

use CakeLteTools\Enum\ListInterface;
use CakeLteTools\Enum\Trait\ListTrait;

enum Gender: string implements ListInterface
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
