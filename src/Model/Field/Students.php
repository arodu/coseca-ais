<?php
declare(strict_types=1);

namespace App\Model\Field;

class Students
{
    public const TYPE_REGULAR = 'regular';
    public const TYPE_VALIDATED = 'validated';

    public const GENDER_MALE = 'M';
    public const GENDER_FEMALE = 'F';

    public static function getGenders(): array
    {
        return [
            static::GENDER_FEMALE => __('Femenino'),
            static::GENDER_MALE => __('Masculino'),
        ];
    }

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
