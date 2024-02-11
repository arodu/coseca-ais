<?php
declare(strict_types=1);

namespace App\Utility;

use App\Model\Entity\Program;
use App\Model\Field\ProgramRegime;

class StudentLevels
{
    /**
     * @param \App\Model\Entity\Program $program
     * @return array
     */
    public static function getList(Program $program): array
    {
        $maxLevel = ProgramRegime::from($program->regime)->maxLevel();

        return static::getArray($maxLevel);
    }

    /**
     * @param \App\Model\Entity\Program $program
     * @return string
     */
    public static function getFormLabel(Program $program): string
    {
        return ProgramRegime::from($program->regime)->formLabel();
    }

    /**
     * @param int $maxLevel
     * @return array
     */
    protected static function getArray(int $maxLevel): array
    {
        $min = floor($maxLevel / 2) + 1;
        $range = range($min, $maxLevel);
        $cardinals = array_map(fn ($level) => $level . '°', $range);

        return array_combine($range, $cardinals);
    }
}
