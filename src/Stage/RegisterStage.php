<?php
declare(strict_types=1);

namespace App\Stage;

use App\Model\Field\Stages;
use Cake\ORM\Locator\LocatorAwareTrait;

class RegisterStage implements StageInterface
{
    use StageTrait;
    use LocatorAwareTrait;

    public function initialize(): void
    {}

    public function close(string $status)
    {
        // close current stage
        $this->StudentStages->updateStatus($this->getStudentStage(), $status);

        // create next stage
        if ($status === Stages::STATUS_SUCCESS) {
            $nextStageKey = $this->getNextStageKey();
            if ($nextStageKey) {
                $this->StudentStages->create([
                    'stage' => $nextStageKey,
                    'student_id' => $this->getStudentId(),
                    'lapse_id' => $this->getStudentStage()->lapse_id,
                ]);
            }
        }
    }
}
