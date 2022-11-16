<?php

declare(strict_types=1);

namespace App\Utility;

use App\Enum\Stage;
use App\Enum\StudentType;
use App\Model\Entity\StudentStage;
use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;

class Stages
{
    public const DATA_KEY = 'key';
    public const DATA_LABEL = 'label';
    public const DATA_CLASS = 'class';
    public const DATA_STATUS = 'status';

    /**
     * @param StudentType $studentType
     * @return array
     */
    /*
    public static function getStageList(StudentType $studentType): array
    {
        $stagesStudentType = static::getStageListStudentType($studentType);
        $stagesAll = Configure::read('Stages');

        $filtered = array_filter($stagesAll, function ($key) use ($stagesStudentType) {
            return in_array($key, $stagesStudentType);
        }, ARRAY_FILTER_USE_KEY);

        return $filtered;
    }
    */

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
