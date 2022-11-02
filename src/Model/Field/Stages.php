<?php
declare(strict_types=1);

namespace App\Model\Field;

use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;

class Stages
{
    public const STAGE_REGISTER = 'register';
    public const STAGE_COURSE = 'course';
    // ...
    public const STAGE_ENDING = 'ending';

    public const DATA_KEY = 'key';
    public const DATA_LABEL = 'label';
    public const DATA_CLASS = 'class';
    public const DATA_STATUS = 'status';

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
    public static function getStageList(?string $stageDataKey = null): array
    {
        $stages = Configure::read('Stages');

        if (empty($stageDataKey)) {
            return $stages;
        }

        if ($stageDataKey === static::DATA_KEY) {
            return array_keys($stages);
        }

        $output = [];
        foreach ($stages as $key => $stage) {
            $output[$key] = $stage[$stageDataKey];
        }

        return $output;
    }

    public static function getStageInfo(string $stageKey): array
    {
        $stageList = static::getStageList();

        if (!isset($stageList[$stageKey])) {
            throw new NotFoundException('$stageKey not found!');
        }

        return array_merge([
            static::DATA_STATUS => static::STATUS_PENDING,
        ], $stageList[$stageKey]);
    }

    /**
     * @param string $currentStage
     * @return string|null
     */
    public static function getNextStageKey(string $currentStage): ?string
    {
        $stageList = static::getStageList(static::DATA_KEY);
        $prev = null;

        foreach ($stageList as $next) {
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
