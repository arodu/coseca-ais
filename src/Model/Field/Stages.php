<?php
declare(strict_types=1);

namespace App\Model\Field;

use App\Stage\CourseStage;
use App\Stage\EndingStage;
use App\Stage\RegisterStage;

class Stages
{
    public const STAGE_REGISTER = 'register';
    public const STAGE_COURSE = 'course';
    // ...
    public const STAGE_ENDING = 'ending';

    public const DATA_KEY = 'key';
    public const DATA_LABEL = 'label';
    public const DATA_CLASS = 'class';

    /**
     * default stage for new Students
     *
     * @return string
     */
    public static function defaultStage(): string
    {
        return static::STAGE_REGISTER;
    }

    /**
     * @return array
     */
    protected static function _list(): array
    {
        return [
            static::STAGE_REGISTER => [
                static::DATA_LABEL => __('Registro'),
                static::DATA_CLASS => RegisterStage::class,
            ],
            static::STAGE_COURSE => [
                static::DATA_LABEL => __('Curso de Servicio Comunitario'),
                static::DATA_CLASS => CourseStage::class,
            ],
            static::STAGE_ENDING => [
                static::DATA_LABEL => __('Finalizacion'),
                static::DATA_CLASS => EndingStage::class,
            ],
        ];
    }

    /**
     * @param string|null $key
     * @return array
     */
    public static function getStages(?string $keyStage = null): array
    {
        $stages = static::_list();

        if (empty($keyStage)) {
            return $stages;
        }

        if ($keyStage === static::DATA_KEY) {
            return array_keys(static::getStages());
        }

        $output = [];
        foreach ($stages as $key => $stage) {
            $output[$key] = $stage[$keyStage];
        }

        return $output;
    }

    public static function getNextStage($currentStage): ?string
    {
        $stages = static::getStages(static::DATA_KEY);
        $prev = null;

        foreach ($stages as $next) {
            if ($prev === $currentStage) {
                return $next;
            }
            $prev = $next;
        }

        return null;
    }

    public const STATUS_PENDING = 'pending';
    public const STATUS_WAITING = 'waiting';
    public const STATUS_IN_PROGRESS = 'in-progress';
    public const STATUS_SUCCESS = 'success';
    public const STATUS_FAIL = 'fail';

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
            static::STATUS_FAIL => __('Fallido'),
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
