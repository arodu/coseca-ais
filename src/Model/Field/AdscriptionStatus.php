<?php
declare(strict_types=1);

namespace App\Model\Field;

use App\Enum\Trait\BasicEnumTrait;
use App\Enum\Trait\ListTrait;

enum AdscriptionStatus: string
{
    use ListTrait;
    use BasicEnumTrait;

    case PENDING = 'pending';
    case OPEN = 'open';
    case CLOSED = 'closed';

    /**
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            static::PENDING => __('Pendiente'),
            static::OPEN => __('Abierto'),
            static::CLOSED => __('Cerrado'),
            default => __('NaN'),
        };
    }
}
