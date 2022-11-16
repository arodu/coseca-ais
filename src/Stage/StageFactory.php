<?php
declare(strict_types=1);

namespace App\Stage;

use App\Model\Entity\StudentStage;
use InvalidArgumentException;

class StageFactory
{
    public static function getInstance(StudentStage $studentStage): StageInterface
    {
        if (empty($studentStage->stage)) {
            throw new InvalidArgumentException();
        }
        $stageClass = $studentStage->getStageField()->getClass();

        return new $stageClass($studentStage);
    }
}
