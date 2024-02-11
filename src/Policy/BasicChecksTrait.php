<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Field\UserRole;
use Authentication\IdentityInterface;

trait BasicChecksTrait
{
    /**
     * @param \Authentication\IdentityInterface $user
     * @return bool
     */
    protected function userIsAdmin(IdentityInterface $user): bool
    {
        return in_array($user->role, UserRole::getAdminGroup());
    }

    /**
     * @param \Authentication\IdentityInterface $user
     * @return bool
     */
    protected function userIsStudent(IdentityInterface $user): bool
    {
        return in_array($user->role, UserRole::getStudentGroup());
    }

    /**
     * @param \Authentication\IdentityInterface $user
     * @param int $studentId
     * @return bool
     */
    protected function studentIsOwner(IdentityInterface $user, int $studentId): bool
    {
        return $this->userIsStudent($user) && $user->current_student?->id === $studentId;
    }
}
