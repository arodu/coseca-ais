<?php
declare(strict_types=1);

namespace App\Model\Field;

use App\Enum\Color;
use App\Enum\FaIcon;
use App\Enum\Trait\ListTrait;

enum StageStatus: string
{
    use ListTrait;

    case WAITING = 'waiting';
    case IN_PROGRESS = 'in-progress';
    case SUCCESS = 'success';
    case FAILED = 'failed';
    case LOCKED = 'locked';

    /**
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            static::WAITING => __('En Espera'),
            static::IN_PROGRESS => __('En Proceso'),
            static::SUCCESS => __('Realizado'),
            static::FAILED => __('Fallido'),
            static::LOCKED => __('Bloqueado'),

            default => __('NaN'),
        };
    }

    /**
     * @return Color
     */
    public function color(): Color
    {
        return match($this) {
            static::WAITING => Color::INFO,
            static::IN_PROGRESS => Color::WARNING,
            static::SUCCESS => Color::SUCCESS,
            static::FAILED => Color::DANGER,
            static::LOCKED => Color::SECONDARY,

            default => Color::SECONDARY,
        };
    }

    /**
     * @return FaIcon
     */
    public function icon(): FaIcon
    {
        return match($this) {
            static::WAITING => FaIcon::WAITING,
            static::IN_PROGRESS => FaIcon::IN_PROGRESS,
            static::SUCCESS => FaIcon::SUCCESS,
            static::FAILED => FaIcon::FAILED,
            static::LOCKED => FaIcon::LOCKED,

            default => FaIcon::DEFAULT,
        };
    }
}
