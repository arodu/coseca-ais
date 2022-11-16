<?php
declare(strict_types=1);

namespace App\Utility;

use App\Model\Entity\Student;
use App\Model\Entity\Tenant;

class Students
{
    public static function getSemesters(): array
    {
        return [
            '6' => '6°',
            '7' => '7°',
            '8' => '8°',
            '9' => '9°',
            '10' => '10°',
        ];
    }

    public static function getYears(): array
    {
        return [
            '3' => '3°',
            '4' => '4°',
            '5' => '5°',
        ];
    }


    public static function getLeves(Tenant $tenant): array
    {
        // @todo logic to select semesters or years
        return static::getSemesters();
    }
}
