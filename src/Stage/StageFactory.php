<?php
declare(strict_types=1);

namespace App\Stage;

use App\Model\Entity\Student;
use App\Model\Entity\StudentStage;
use App\Model\Field\Stages;
use Cake\Http\Exception\NotFoundException;
use InvalidArgumentException;

class StageFactory
{
    public static function getInstance(StudentStage $studentStage): StageInterface
    {
        $stages = Stages::getStages();

        if (empty($studentStage->stage)) {
            throw new InvalidArgumentException();
        }

        if (!isset($stages[$studentStage->stage])) {
            throw new InvalidArgumentException();
        }

        return new $stages[$studentStage->stage][Stages::DATA_CLASS]($studentStage);
    }
}
