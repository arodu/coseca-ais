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
    case SUPERUSER = 'superuser';

    const GROUP_STUDENT = 'student';
    const GROUP_ADMIN = 'admin';
    const GROUP_SUPERADMIN = 'superadmin';
    const GROUP_ROOT = 'root';

    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            static::STUDENT => __('Estudiante'),
            static::ASSISTANT => __('Asistente'),
            static::SUPERUSER => __('superuser'),
            static::ADMIN => __('admin'),
            default => __('NaN'),
        };
    }

    /**
     * @param string $name Group name
     * @return array
     */
    public static function group(string $name): array
    {
        $groups = [
            static::GROUP_STUDENT => [
                static::STUDENT,
            ],
            static::GROUP_ADMIN => [
                static::ASSISTANT,
                static::ADMIN,
                static::SUPERUSER,
            ],
            static::GROUP_SUPERADMIN => [
                static::ADMIN,
                static::SUPERUSER,
            ],
            static::GROUP_ROOT => [
                static::SUPERUSER,
            ],
        ];

        return $groups[$name] ?? [];
    }

    /**
     * @param string $name Group name
     * @return boolean
     */
    public function inGroup(string $name): bool
    {
        return in_array($this, static::group($name), true);
    }

    /**
     * @param string $name Group name
     * @return boolean
     */
    public function isGroup(string $name): bool
    {
        return $this->inGroup($name);
    }

    /**
     * @param string $name Group name
     * @return array
     */
    public static function getGroup(string $name): array
    {
        return static::values(static::group($name));
    }

    /**
     * @return array
     */
    public static function getStudentGroup(): array
    {
        return static::getGroup(static::GROUP_STUDENT);
    }

    /**
     * @return boolean
     */
    public function isStudentGroup(): bool
    {
        return $this->isGroup(static::GROUP_STUDENT);
    }

    /**
     * @return array
     */
    public static function getAdminGroup(): array
    {
        return static::getGroup(static::GROUP_ADMIN);
    }


    /**
     * @return boolean
     */
    public function isAdminGroup(): bool
    {
        return $this->inGroup(static::GROUP_ADMIN);
    }

    /**
     * @return array
     */
    public static function getSuperAdminGroup(): array
    {
        return static::values(static::group(static::GROUP_SUPERADMIN));
    }

    /**
     * @return boolean
     */
    public function isSuperAdminGroup(): bool
    {
        return $this->inGroup(static::GROUP_SUPERADMIN);
    }
}
