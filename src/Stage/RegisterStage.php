<?php
declare(strict_types=1);

namespace App\Stage;

use App\Model\Entity\StudentStage;
use App\Model\Field\Stages;
use Cake\Log\Log;
use Cake\ORM\Locator\LocatorAwareTrait;

class RegisterStage implements StageInterface
{
    use StageTrait;
    use LocatorAwareTrait;

    public function initialize(): void
    {}
    
    public function create($options = []): StudentStage
    {
        $studentStage = $this->getStudentStage();
        if ($studentStage) {
            Log::info(__('StudentStage already exists!'));
            return $studentStage;
        }

        $data = array_merge([
            'student_id' => $this->getStudent()->id,
            'lapse_id' => $this->StudentStages->Lapses->getCurrentLapse()->id,
            'stage' => $this->getStageKey(),
            'status' => Stages::STATUS_IN_PROGRESS,
        ], $options);
        $stage = $this->StudentStages->newEntity($data);

        return $this->StudentStages->saveOrFail($stage);
    }

    public function close(string $status)
    {
        // close current stage
        $this->changeStatus($status);

        // create next stage
        if ($status === Stages::STATUS_SUCCESS) {
            $nextStageKey = $this->getNextStageKey();
            if ($nextStageKey) {
                StageFactory::getInstance($nextStageKey, $this->getStudentId())
                    ->create([
                        'lapse_id' => $this->getStudentStage()->lapse_id,
                    ]);
            }
        }
    }
}
