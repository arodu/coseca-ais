<?php
declare(strict_types=1);

namespace App\Model\Field;

class Students
{
    public const TYPE_REGULAR = 'regular';
    public const TYPE_VALIDATED = 'validated';

    /**
     * @param string|null $type
     * @return mixed
     */
    public static function getTypes(string $type = null): mixed
    {
        $typeList = [
            static::TYPE_REGULAR => __('Regular'),
            static::TYPE_VALIDATED => __('Convalidación'),
        ];

        if (empty($type)) {
            return $typeList;
        }

        return $typeList[$type] ?? null;
    }

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
