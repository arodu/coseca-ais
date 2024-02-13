<?php
declare(strict_types=1);

namespace App\Enum;

use CakeLteTools\Enum\BadgeInterface;
use CakeLteTools\Enum\Color;
use CakeLteTools\Enum\Trait\BasicEnumTrait;

enum Active implements BadgeInterface
{
    use BasicEnumTrait;

    case TRUE;
    case FALSE;

    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            static::TRUE => __('Activo'),
            static::FALSE => __('Inactivo'),
        };
    }

    /**
     * @return \CakeLteTools\Enum\Color
     */
    public function color(): Color
    {
        return match ($this) {
            static::TRUE => Color::PRIMARY,
            static::FALSE => Color::SECONDARY,
        };
    }

    /**
     * @param bool|null $active Active
     * @return self|null
     */
    public static function get(?bool $active = null): ?self
    {
        if (is_null($active)) {
            return null;
        }

        return $active ? self::TRUE : self::FALSE;
    }
}
