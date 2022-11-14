<?php
declare(strict_types=1);

namespace App\Enum;

enum StageStatus: string
{
    use ToArrayTrait;

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
}
