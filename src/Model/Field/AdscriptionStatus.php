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
    case VALIDATED = 'validated';
    case CANCELLED = 'cancelled';

    /**
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            static::PENDING => __('Pendiente'),
            static::OPEN => __('Abierto'),
            static::CLOSED => __('Cerrado'),
            static::VALIDATED => __('Validado'),
            static::CANCELLED => __('Cancelado'),
            default => __('NaN'),
        };
    }

    public function color(): Color
    {
        return match($this) {
            static::PENDING => Color::WARNING,
            static::OPEN => Color::SUCCESS,
            static::CLOSED => Color::DANGER,
            static::VALIDATED => Color::PRIMARY,
            static::CANCELLED => Color::SECONDARY,
            default => Color::SECONDARY,
        };
    }

    public static function getEditableObj(): array
    {
        return [
            static::PENDING,
            static::OPEN,
            static::CLOSED,
            static::CANCELLED,
        ];
    }

    public static function getEditableListLabel(): array
    {
        return static::toListLabel(static::getEditableObj());
    }

}
