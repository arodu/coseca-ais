<?php
declare(strict_types=1);

namespace App\Enum;

use Cake\I18n\FrozenDate;

enum StatusDate
{
    case PENDING;
    case IN_PROGRESS;
    case TIMED_OUT;

    /**
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            static::PENDING => __('Pendiente'),
            static::IN_PROGRESS => __('En Progreso'),
            static::TIMED_OUT => __('Caducado'),
        };
    }

    /**
     * @param FrozenDate|null $start_date
     * @param FrozenDate|null $end_date
     * @return StatusDate|null
     */
    public static function get(?FrozenDate $start_date, ?FrozenDate $end_date = null): ?StatusDate
    {
        if (empty($end_date)) {
            $end_date = $start_date;
        }

        return match(true) {
            empty($start_date) => null,
            $start_date->isFuture() => static::PENDING,
            $end_date->isPast() => static::TIMED_OUT,
            FrozenDate::now()->between($start_date, $end_date) => static::IN_PROGRESS,

            default => null,
        };
    }

    /**
     * @param StatusDate $status
     * @return bool
     */
    public function is(StatusDate $status): bool
    {
        return $this === $status;
    }
}
