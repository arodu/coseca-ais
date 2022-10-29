<?php
declare(strict_types=1);

namespace App\Model\Field;

class Users
{
    public const ROLE_STUDENT = 'student';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_ASSISTANT = 'assistant';

    public static function getAdminRoles(): array
    {
        return [
            static::ROLE_ADMIN,
            static::ROLE_ASSISTANT,
        ];
    }

    public static function getStudentRoles(): array
    {
        return [
            static::ROLE_STUDENT,
        ];
    }
}