<?php

declare(strict_types=1);

namespace App\Utility;

use App\Model\Field\StageField;
use App\Model\Field\StudentType;

class Stages
{

    /**
     * @param StageField $currentStage
     * @param StudentType $studentType
     * @return StageField|null
     */
    public static function getNextStageField(StageField $currentStage, StudentType $studentType): ?StageField
    {
        $stageList = $studentType->getStageFieldList();
        $prev = null;
        foreach ($stageList as $next) {
            if ($prev === $currentStage) {
                return $next;
            }
            $prev = $next;
        }

        return null;
    }
}
