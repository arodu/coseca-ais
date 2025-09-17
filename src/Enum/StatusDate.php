<?php
declare(strict_types=1);

namespace App\Enum;

use Cake\I18n\FrozenDate;
use CakeLteTools\Enum\BadgeInterface;
use CakeLteTools\Enum\Color;
use CakeLteTools\Enum\Trait\BasicEnumTrait;

enum StatusDate implements BadgeInterface
{
    use BasicEnumTrait;

    case PENDING;
    case IN_PROGRESS;
    case TIMED_OUT;

    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            static::PENDING => __('Pendiente'),
            static::IN_PROGRESS => __('En proceso'),
            static::TIMED_OUT => __('Caducado'),
        };
    }

    /**
     * @return \CakeLteTools\Enum\Color
     */
    public function color(): Color
    {
        return match ($this) {
            static::PENDING => Color::INFO,
            static::IN_PROGRESS => Color::WARNING,
            static::TIMED_OUT => Color::DANGER,
        };
    }

    /**
     * @param \Cake\I18n\FrozenDate|null $start_date The start date.
     * @param \Cake\I18n\FrozenDate|null $end_date The end date.
     * @return \App\Enum\StatusDate|null
     */
    public static function get(?FrozenDate $start_date, ?FrozenDate $end_date = null): ?StatusDate
    {
        if (empty($end_date)) {
            $end_date = $start_date;
        }

        return match (true) {
            empty($start_date) => null,
            $start_date->isFuture() => static::PENDING,
            $end_date->isPast() => static::TIMED_OUT,
            FrozenDate::now()->between($start_date, $end_date) => static::IN_PROGRESS,

            default => null,
        };
    }
}
