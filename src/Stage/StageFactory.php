<?php
declare(strict_types=1);

namespace App\Stage;

use App\Model\Entity\Student;
use App\Model\Field\Stages;
use Cake\Http\Exception\NotFoundException;

class StageFactory
{
    public static function getInstance(string $stageKey, Student $student): StageInterface
    {
        $stages = Stages::getStages();

        if (!isset($stages[$stageKey])) {
            throw new NotFoundException();
        }

        return new $stages[$stageKey][Stages::DATA_CLASS]($stageKey, $student);
    }
}
