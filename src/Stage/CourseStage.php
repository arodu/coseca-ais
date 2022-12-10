<?php

declare(strict_types=1);

namespace App\Stage;

use App\Model\Field\StageStatus;

class CourseStage implements StageInterface
{
    use StageTrait;

    public function initialize(): void
    {
    }

    public function close(StageStatus $stageStatus)
    {
        // close current stage
        $this->StudentStages->updateStatus($this->getStudentStage(), $stageStatus->value);

        // create next stage
        if ($stageStatus === StageStatus::SUCCESS) {
            $nextStageField = $this->getNextStageField();
            if ($nextStageField) {
                $this->StudentStages->create([
                    'stage' => $nextStageField->value,
                    'student_id' => $this->getStudentId(),
                    'lapse_id' => $this->getStudentStage()->lapse_id,
                ]);
            }
        }
    }
}
