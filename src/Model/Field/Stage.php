<?php
declare(strict_types=1);

namespace App\Model\Field;

class Stage
{
    public const CODE_REGISTER = 'register';

    public const STATUS_PENDING = 'pending';
    public const STATUS_WAITING = 'waiting';
    public const STATUS_IN_PROGRESS = 'in-progress';
    public const STATUS_SUCCESS = 'success';

    /**
     * @return array
     */
    public static function getStatuses(): array
    {
        return [
            static::STATUS_PENDING => __('Pendiente'),
            static::STATUS_WAITING => __('En espera'),
            static::STATUS_IN_PROGRESS => __('En progreso'),
            static::STATUS_SUCCESS => __('Realizado'),
        ];
    }

    /**
     * @param string $status
     * @return string|null
     */
    public static function getStatus(string $status): ?string
    {
        return static::getStatuses()[$status] ?? null;
    }
}
