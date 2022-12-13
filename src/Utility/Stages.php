<?php

declare(strict_types=1);

namespace App\Utility;

use App\Model\Field\StageField;
use App\Model\Field\StudentType;
use Cake\Core\Configure;
use Cake\Utility\Hash;

class Stages
{
    /**
     * @param StageField $currentStage
     * @param StudentType $studentType
     * @return StageField|null
     */
    public static function getNextStageField(StageField $currentStage, StudentType $studentType): ?StageField
    {
        $stageList = self::getStageFieldList($studentType);
        $prev = null;
        foreach ($stageList as $next) {
            if ($prev === $currentStage) {
                return $next;
            }
            $prev = $next;
        }

        return null;
    }

    /**
     * @param StudentType $studentType
     * @return array
     */
    public static function getStageFieldList(StudentType $studentType): array
    {
        return Hash::get(Configure::read('StageGroups'), $studentType->value, []);
    }
}
