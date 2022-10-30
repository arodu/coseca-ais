<?php
declare(strict_types=1);

namespace App\Stage;

use App\Model\Entity\StudentStage;
use App\Model\Field\Stages;
use Cake\Log\Log;

class CourseStage implements StageInterface
{
    use StageTrait;

    public function initialize(): void {}
    
    public function create($options = []): StudentStage
    {
        $studentStage = $this->getStudentStage();
        if ($studentStage) {
            Log::info(__('StudentStage already exists!'));
            return $studentStage;
        }

        $data = array_merge([
            'student_id' => $this->getStudentId(),
            'stage' => $this->getStageKey(),
            'status' => Stages::STATUS_WAITING,
            'lapse_id' => $this->StudentStages->Lapses->getCurrentLapse()->id,
        ], $options);
        return $this->_persist($data);
    }

    public function close(string $status) {}
}
