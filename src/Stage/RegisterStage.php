<?php
declare(strict_types=1);

namespace App\Stage;

use App\Model\Entity\StudentStage;
use App\Model\Field\Stages;
use Cake\ORM\Locator\LocatorAwareTrait;

class RegisterStage implements StageInterface
{
    use StageTrait;
    use LocatorAwareTrait;
    
    public function create(): StudentStage
    {
        $StudentStages = $this->fetchTable('StudentStages');
        $stage = $StudentStages->newEntity([
            'student_id' => $this->student->id,
            'lapse_id' => $StudentStages->Lapses->getCurrentLapse()->id,
            'created_by' => 1,
            'modified_by' => 1,
            'stage' => Stages::STAGE_REGISTER,
            'status' => Stages::STATUS_IN_PROGRESS,
        ]);

        return $StudentStages->saveOrFail($stage);
    }

}
