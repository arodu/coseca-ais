<?php

declare(strict_types=1);

namespace App\Utility;

use App\Model\Field\StageField;
use App\Model\Field\StageStatus;

class ReportsUtility
{
    public static function getStatusList(): array
    {
        return [
            StageStatus::WAITING,
            StageStatus::IN_PROGRESS,
            StageStatus::REVIEW,
            StageStatus::SUCCESS,
        ];
    }

    public static function getStageList(): array
    {
        return [
            StageField::REGISTER,
            StageField::COURSE,
            StageField::ADSCRIPTION,
            StageField::TRACKING,
            StageField::RESULTS,
            StageField::ENDING,
        ];
    }
}
