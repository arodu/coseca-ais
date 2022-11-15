<?php
declare(strict_types=1);

namespace App\Enum;

use App\Enum\Trait\ListTrait;

enum StageStatus: string
{
    use ListTrait;

    case PENDING = 'pending';
    case WAITING = 'waiting';
    case IN_PROGRESS = 'in-progress';
    case SUCCESS = 'success';
    case FAILED = 'failed';

    /**
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            static::PENDING => __('Pendiente'),
            static::WAITING => __('En Espera'),
            static::IN_PROGRESS => __('En Proceso'),
            static::SUCCESS => __('Realizado'),
            static::FAILED => __('Fallido'),

            default => __('NaN'),
        };
    }

    /**
     * @return Color
     */
    public function color(): Color
    {
        return match($this) {
            static::PENDING => Color::SECONDARY,
            static::WAITING => Color::INFO,
            static::IN_PROGRESS => Color::WARNING,
            static::SUCCESS => Color::SUCCESS,
            static::FAILED => Color::DANGER,

            default => Color::SECONDARY,
        };
    }

    /**
     * @return FaIcon
     */
    public function icon(): FaIcon
    {
        return match($this) {
            static::PENDING => FaIcon::PENDING,
            static::WAITING => FaIcon::WAITING,
            static::IN_PROGRESS => FaIcon::IN_PROGRESS,
            static::SUCCESS => FaIcon::SUCCESS,
            static::FAILED => FaIcon::FAILED,

            default => FaIcon::DEFAULT,
        };
    }
}
