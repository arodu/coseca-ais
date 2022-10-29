<?php
declare(strict_types=1);

namespace App\Stage;

use App\Model\Field\Stages;
use Cake\Http\Exception\NotFoundException;

class StageFactory
{
    public static function create(string $stageKey, $options = []): StageInterface
    {
        $stages = Stages::getStages();

        if (!isset($stages[$stageKey])) {
            throw new NotFoundException();
        }

        return new $stages[$stageKey][Stages::DATA_CLASS]($options);
    }
}
