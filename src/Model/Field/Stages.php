<?php
declare(strict_types=1);

namespace App\Model\Field;

use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;

class Stages
{
    public const STAGE_REGISTER = 'register';
    public const STAGE_COURSE = 'course';
    public const STAGE_ADSCRIPTION = 'adscription';
    public const STAGE_TRACKING = 'tracking';
    public const STAGE_ENDING = 'ending';
    public const STAGE_VALIDATION = 'validation';

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
     * @param string $studentType
     * @return array
     */
    public static function getStageListStudentType(string $studentType): array
    {
        switch ($studentType) {
            case Students::TYPE_VALIDATED:
                return [
                    static::STAGE_REGISTER,
                    static::STAGE_VALIDATION,
                ];
                break;
            case Students::TYPE_REGULAR:
            default:
                return [
                    static::STAGE_REGISTER,
                    static::STAGE_COURSE,
                    static::STAGE_ADSCRIPTION,
                    static::STAGE_TRACKING,
                    static::STAGE_ENDING,
                ];
                break;
        }
    }

    /**
     * @param string $studentType
     * @return array
     */
    public static function getStageList(string $studentType): array
    {
        $stagesStudentType = static::getStageListStudentType($studentType);
        $stagesAll = Configure::read('Stages');

        $filtered = array_filter($stagesAll, function ($key) use ($stagesStudentType) {
            return in_array($key, $stagesStudentType);
        }, ARRAY_FILTER_USE_KEY);

        return $filtered;
    }

    /**
     * @param array $stageList
     * @param string $dataSet
     * @return array
     */
    public static function getStagesFilter(array $stageList, string $dataSet = self::DATA_KEY): array
    {
        if ($dataSet === static::DATA_KEY) {
            return array_keys($stageList);
        }

        return array_filter($stageList, function ($item) use ($dataSet) {
            return $item[$dataSet];
        });
    }

    /**
     * @param string $stageKey
     * @return array
     */
    public static function getStageInfo(string $stageKey): array
    {
        $stagesAll = Configure::read('Stages');

        if (!isset($stagesAll[$stageKey])) {
            throw new NotFoundException('$stageKey not found!');
        }

        return $stagesAll[$stageKey];
    }

    /**
     * @param string $currentStage
     * @return string|null
     */
    public static function getNextStageKey(string $currentStage, string $studentType): ?string
    {
        $stageList = static::getStageList($studentType);
        $prev = null;
        foreach (array_keys($stageList) as $next) {
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
