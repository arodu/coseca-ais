<?php

declare(strict_types=1);

namespace App\Model\Field;

use App\Enum\Trait\BasicEnumTrait;
use App\Enum\Trait\ListTrait;

enum UserRole: string
{
    use ListTrait;
    use BasicEnumTrait;

    case STUDENT = 'student';
    case ADMIN = 'admin';
    case ASSISTANT = 'assistant';
    case SUPERUSER = 'superuser';

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

    public static function getStudentRoles(): array
    {
        return [
            static::STUDENT,
        ];
    }

    public static function getStudentGroup(): array
    {
        return static::values(static::getStudentRoles());
    }

    public static function getAdminRoles(): array
    {
        return [
            static::ASSISTANT,
            static::ADMIN,
            static::SUPERUSER,
        ];
    }

    public static function getAdminGroup(): array
    {
        return static::values(static::getAdminRoles());
    }

    public static function getSuperAdminRoles(): array
    {
        return [
            static::ADMIN,
            static::SUPERUSER,
        ];
    }

    public static function getSuperAdminGroup(): array
    {
        return static::values(static::getSuperAdminRoles());
    }

    public function isStudentGroup(): bool
    {
        return in_array($this, static::getStudentRoles(), true);
    }

    public function isAdminGroup(): bool
    {
        return in_array($this, static::getAdminRoles(), true);
    }
}
