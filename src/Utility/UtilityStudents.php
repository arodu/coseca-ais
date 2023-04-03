<?php

declare(strict_types=1);

namespace App\Utility;

use App\Model\Entity\Program;
use App\Model\Field\ProgramRegime;

class UtilityStudents
{
    public static function getBiannual(): array
    {
        return [
            '6' => '6°',
            '7' => '7°',
            '8' => '8°',
            '9' => '9°',
            '10' => '10°',
        ];
    }

    public static function getQuarterly(): array
    {
        return [
            '7' => '7°',
            '8' => '8°',
            '9' => '9°',
            '10' => '10°',
            '11' => '11°',
            '12' => '12°',
            '13' => '13°',
            '14' => '14°',
            '15' => '15°',
        ];
    }

    public static function getAnnualized(): array
    {
        return [
            '3' => '3°',
            '4' => '4°',
            '5' => '5°',
        ];
    }

    public static function getLeves(Program $program): array
    {
        switch ($program->regime) {
            case ProgramRegime::QUARTERLY:
                return static::getQuarterly();
                break;

            case ProgramRegime::ANNUALIZED:
                return static::getAnnualized();
                break;
            case ProgramRegime::BIANNUAL:
            default:
                return static::getBiannual();
                break;
        }
    }

    public static function getLabelLevel(Program $program): string
    {
        switch ($program->regime) {
            case ProgramRegime::QUARTERLY:
                return __('Trimestre actual');
                break;

            case ProgramRegime::ANNUALIZED:
                return __('Año actual');
                break;
            case ProgramRegime::BIANNUAL:
            default:
                return __('Semestre actual');
                break;
        }
    }
}
