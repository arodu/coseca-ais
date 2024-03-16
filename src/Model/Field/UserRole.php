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
    case TUTOR = 'tutor';
    case MANAGER = 'manager';
    case ROOT = 'root';

    public const GROUP_STUDENT = 'group_student';
    public const GROUP_ADMIN = 'group_admin';
    public const GROUP_STAFF = 'group_staff';
    public const GROUP_TUTOR = 'group_tutor';
    public const GROUP_MANAGER = 'group_manager';
    public const GROUP_ROOT = 'group_root';

    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            static::STUDENT => __('Estudiante'),
            static::ASSISTANT => __('Asistente'),
            static::TUTOR => __('Tutor Académico'),
            static::ADMIN => __('Admin'),
            static::ROOT => __('Root'),
            static::MANAGER => __('Manager'),
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
            static::GROUP_TUTOR => [
                static::TUTOR,
                static::ROOT,
            ],
            static::GROUP_MANAGER => [
                static::MANAGER,
                static::ROOT,
            ],
            static::GROUP_ROOT => [
                static::ROOT,
            ],
        ];

        return $groups[$group_name] ?? [];
    }

    /**
     * @param string $group_name Group name
     * @return bool
     */
    public function isGroup(string $group_name): bool
    {
        return in_array($this, static::group($group_name), true);
    }

    /**
     * @return bool
     * @deprecated use isGroup(UserRole::GROUP_ADMIN) instead
     */
    public function isAdminGroup(): bool
    {
        trigger_error('Deprecated method ' . __METHOD__, E_USER_DEPRECATED);
        return $this->isGroup(static::GROUP_ADMIN);
    }

    /**
     * @return bool
     * @deprecated use isGroup(UserRole::GROUP_STUDENT) instead
     */
    public function isStudentGroup(): bool
    {
        trigger_error('Deprecated method ' . __METHOD__, E_USER_DEPRECATED);
        return $this->isGroup(static::GROUP_STUDENT);
    }

    /**
     * @return bool
     * @deprecated use isGroup(UserRole::GROUP_STAFF) instead
     */
    public function isStaffGroup(): bool
    {
        trigger_error('Deprecated method ' . __METHOD__, E_USER_DEPRECATED);
        return $this->isGroup(static::GROUP_STAFF);
    }

    /**
     * @return bool
     * @deprecated use isGroup(UserRole::GROUP_ROOT) instead
     */
    public function isRootGroup(): bool
    {
        trigger_error('Deprecated method ' . __METHOD__, E_USER_DEPRECATED);
        return $this->isGroup(static::GROUP_ROOT);
    }

    /**
     * @param string $group_name
     * @return array
     */
    public static function getGroup(string $group_name): array
    {
        return static::values(static::group($group_name));
    }

    /**
     * @return array
     * @deprecated use getGroup(UserRole::GROUP_ADMIN) instead
     */
    public static function getAdminGroup(): array
    {
        trigger_error('Deprecated method ' . __METHOD__, E_USER_DEPRECATED);
        return static::getGroup(static::GROUP_ADMIN);
    }

    /**
     * @return array
     * @deprecated use getGroup(UserRole::GROUP_STUDENT) instead
     */
    public static function getStudentGroup(): array
    {
        trigger_error('Deprecated method ' . __METHOD__, E_USER_DEPRECATED);
        return static::getGroup(static::GROUP_STUDENT);
    }

    /**
     * @return array
     * @deprecated use getGroup(UserRole::GROUP_STAFF) instead
     */
    public static function getStaffGroup(): array
    {
        trigger_error('Deprecated method ' . __METHOD__, E_USER_DEPRECATED);
        return static::getGroup(static::GROUP_STAFF);
    }


}
