<?php
declare(strict_types=1);

namespace App\Stage;

use App\Model\Entity\StudentStage;
use App\Model\Field\Stages;

class CourseStage implements StageInterface
{
    use StageTrait;

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
            'created_by' => 1,
            'modified_by' => 1,
            'stage' => $this->getStageKey(),
            'status' => Stages::STATUS_WAITING,
        ], $options);
        $stage = $this->StudentStages->newEntity($data);

        return $this->StudentStages->saveOrFail($stage);
    }

    public function close(string $status)
    {}
}
