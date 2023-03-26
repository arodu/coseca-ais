<?php
declare(strict_types=1);

namespace App\Model\Field;

use App\Enum\BadgeInterface;
use App\Enum\Color;
use App\Enum\Trait\BasicEnumTrait;
use App\Enum\Trait\ListTrait;

enum AdscriptionStatus: string implements BadgeInterface
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

    public function color(): Color
    {
        return match($this) {
            static::PENDING => Color::WARNING,
            static::OPEN => Color::SUCCESS,
            static::CLOSED => Color::DANGER,
            default => Color::SECONDARY,
        };
    }
}
