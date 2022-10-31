<?php
declare(strict_types=1);

namespace App\Model\Field;

use App\Stage\CourseStage;
use App\Stage\EndingStage;
use App\Stage\RegisterStage;
use Cake\Core\Configure;

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
     * @param string|null $stageKey
     * @return array
     */
    public static function getStages(?string $stageKey = null): array
    {
        $stages = Configure::read('Stages');

        if (empty($stageKey)) {
            return $stages;
        }

        if ($stageKey === static::DATA_KEY) {
            return array_keys(static::getStages());
        }

        $output = [];
        foreach ($stages as $key => $stage) {
            $output[$key] = $stage[$stageKey];
        }

        return $output;
    }

    /**
     * @param string $currentStage
     * @return string|null
     */
    public static function getNextStageKey(string $currentStage): ?string
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
    public const STATUS_FAILED = 'failed';

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
            static::STATUS_FAILED => __('Fallido'),
        ];
    }

    /**
     * @param string $status
     * @return string|null
     */
    public static function getStatusLabel(string $status): ?string
    {
        return static::getStatuses()[$status] ?? null;
    }
}
