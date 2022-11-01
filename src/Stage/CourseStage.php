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

    public function defaultValues(): array
    {
        return [
            'lapse_id' => $this->StudentStages->Lapses->getCurrentLapse()->id,
            'status' => Stages::STATUS_WAITING,
        ];
    }

    public function close(string $status) {}
}
