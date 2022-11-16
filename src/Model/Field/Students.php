<?php
declare(strict_types=1);

namespace App\Model\Field;

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

}
