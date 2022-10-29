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
    {
        /** @var \App\Model\Table\StudentStagesTable $StudentStages */
        $this->StudentStages = $this->fetchTable('StudentStages');
    }
    
    public function create($options = []): StudentStage
    {
        $studentStage = $this->getStudentStage();
        if ($studentStage) {
            Log::info(__('StudentStage already exists!'));
            return $studentStage;
        }

        $data = array_merge([
            'student_id' => $this->student->id,
            'lapse_id' => $this->StudentStages->Lapses->getCurrentLapse()->id,
            'created_by' => 1,
            'modified_by' => 1,
            'stage' => $this->getKey(),
            'status' => Stages::STATUS_IN_PROGRESS,
        ], $options);
        $stage = $this->StudentStages->newEntity($data);

        return $this->StudentStages->saveOrFail($stage);
    }
}
