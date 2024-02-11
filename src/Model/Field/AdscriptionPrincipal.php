<?php
declare(strict_types=1);

namespace App\Model\Field;

use CakeLteTools\Enum\BadgeInterface;
use CakeLteTools\Enum\Color;
use CakeLteTools\Enum\Trait\BasicEnumTrait;

enum AdscriptionPrincipal implements BadgeInterface
{
    use BasicEnumTrait;

    case PRINCIPAL;
    case NOT_PRINCIPAL;

    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            static::PRINCIPAL => __('Principal'),
            static::NOT_PRINCIPAL => '',
        };
    }

    public function color(): Color
    {
        return match ($this) {
            static::PRINCIPAL => Color::PRIMARY,
            static::NOT_PRINCIPAL => Color::SECONDARY,
        };
    }

    /**
     * @param null $principal
     * @return self|null
     */
    public static function get(?bool $principal = null): ?self
    {
        if (is_null($principal)) {
            return null;
        }

        return $principal ? self::PRINCIPAL : self::NOT_PRINCIPAL;
    }
}
