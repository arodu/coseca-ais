<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\StudentAdscription;
use Authorization\Policy\Result;
use App\Model\Field\AdscriptionStatus;
use App\Model\Field\UserRole;
use Authentication\IdentityInterface;

class StudentAdscriptionPolicy
{
    /**
     * @param IdentityInterface $user
     * @param StudentAdscription $adscription
     * @return Result
     */
    public function canAddTracking(IdentityInterface $user, StudentAdscription $adscription)
    {
        $userIsStudent = in_array($user->role, UserRole::getStudentGroup());
        $userIsAdmin = in_array($user->role, UserRole::getAdminGroup());
        $userIsOwner = $adscription->student_id == $user?->current_student?->id;
        $adscriptionIsOpen = $adscription->statusObj->is([AdscriptionStatus::OPEN]);

        if ($adscriptionIsOpen && $userIsStudent && $userIsOwner) {
            return true;
        }

        if ($adscriptionIsOpen && $userIsAdmin) {
            return true;
        }

        return false;
    }

    public function canDeleteTracking(IdentityInterface $user, StudentAdscription $adscription)
    {
        $userIsStudent = in_array($user->role, UserRole::getStudentGroup());
        $userIsAdmin = in_array($user->role, UserRole::getAdminGroup());
        $userIsOwner = $adscription->student_id == $user?->current_student?->id;
        $adscriptionIsOpen = $adscription->statusObj->is([AdscriptionStatus::OPEN]);

        if ($adscriptionIsOpen && $userIsStudent && $userIsOwner) {
            return true;
        }

        if ($adscriptionIsOpen && $userIsAdmin) {
            return true;
        }

        return false;
    }

    public function canValidate(IdentityInterface $user, StudentAdscription $adscription)
    {
        $userIsAdmin = in_array($user->role, UserRole::getAdminGroup());
        $adscriptionIsClosed = $adscription->statusObj->is([AdscriptionStatus::CLOSED]);
        if ($userIsAdmin && $adscriptionIsClosed) {
            return true;
        }

        return true;
    }
}
