<?php

declare(strict_types=1);

namespace App\Model\Field;

use CakeLteTools\Enum\ListInterface;
use CakeLteTools\Enum\Trait\BasicEnumTrait;
use CakeLteTools\Enum\Trait\ListTrait;

enum UserRole: string implements ListInterface
{
    use ListTrait;
    use BasicEnumTrait;

    case STUDENT = 'student';
    case ADMIN = 'admin';
    case ASSISTANT = 'assistant';
    case ROOT = 'root';

    const GROUP_STUDENT = 'student';
    const GROUP_ADMIN = 'admin';
    const GROUP_STAFF = 'staff';
    const GROUP_ROOT = 'root';

    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            static::STUDENT => __('Estudiante'),
            static::ASSISTANT => __('Asistente'),
            static::ADMIN => __('Admin'),
            static::ROOT => __('Root'),
            default => __('NaN'),
        };
    }

    /**
     * @param string $group_name Group name
     * @return array
     */
    public static function group(string $group_name): array
    {
        $groups = [
            static::GROUP_STUDENT => [
                static::STUDENT,
            ],
            static::GROUP_STAFF => [
                static::ASSISTANT,
                static::ADMIN,
                static::ROOT,
            ],
            static::GROUP_ADMIN => [
                static::ADMIN,
                static::ROOT,
            ],
            static::GROUP_ROOT => [
                static::ROOT,
            ],
        ];

        return $groups[$group_name] ?? [];
    }

    /**
     * @param string $name Group name
     * @return boolean
     */
    public function isGroup(string $group_name): bool
    {
        return in_array($this, static::group($group_name), true);
    }

    public static function getAdminGroup(): array
    {
        return static::values(static::group(static::GROUP_ADMIN));
    }

    public static function getStudentGroup(): array
    {
        return static::values(static::group(static::GROUP_STUDENT));
    }

    public static function getStaffGroup(): array
    {
        return static::values(static::group(static::GROUP_STAFF));
    }
}
