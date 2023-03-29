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
    public function canManageTracking(IdentityInterface $user, StudentAdscription $adscription)
    {
        if (
            in_array($user->role, UserRole::getStudentGroup())
            && $adscription->student_id != $user->current_student->id
        ) {
            return new Result(false, 'student-not-owner');
        }

        if (!$adscription->statusObj->is([AdscriptionStatus::OPEN])) {
            return new Result(false, 'adscription-not-open');
        }

        return new Result(true);
    }
}
