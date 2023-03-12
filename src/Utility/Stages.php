<?php

declare(strict_types=1);

namespace App\Utility;

use App\Model\Entity\StudentStage;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Model\Field\StudentType;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
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

    /**
     * @param int $student_id
     * @param StageField $stageField
     * @param StageStatus $stageStatus
     * @return StudentStage|bool
     */
    public static function closeStudentStage(int $student_id, StageField $stageField, StageStatus $stageStatus): StudentStage|bool
    {
        $studentStagesTable = TableRegistry::getTableLocator()->get('StudentStages');

        $studentStage = $studentStagesTable->find('byStudentStage', [
            'stage' => $stageField,
            'student_id' => $student_id,
        ])->first();
        
        return $studentStagesTable->close($studentStage, $stageStatus);
    }
}
