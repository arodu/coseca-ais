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
        };
    }

    public function color(): string
    {
        return match($this) {
            static::PENDING => 'secondary',
            static::WAITING => 'info',
            static::IN_PROGRESS => 'warning',
            static::SUCCESS => 'success',
            static::FAILED => 'danger',
        };
    }
}
