<?php

declare(strict_types=1);

namespace App\Stage;

use App\Model\Field\StageStatus;

class AdscriptionStage implements StageInterface
{
    use StageTrait;

    public function initialize(): void
    {
    }

    public function close(StageStatus $stageStatus)
    {
    }
}
