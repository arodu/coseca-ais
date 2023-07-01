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
    use BasicChecksTrait;

    /**
     * @param IdentityInterface $user
     * @param StudentAdscription $adscription
     * @return Result
     */
    public function canAddTracking(IdentityInterface $user, StudentAdscription $adscription)
    {
        $adscriptionIsOpen = $adscription->getStatus()?->is([AdscriptionStatus::OPEN]);

        if ($adscriptionIsOpen && $this->studentIsOwner($user, $adscription->student_id)) {
            return true;
        }

        if ($adscriptionIsOpen && $this->userIsAdmin($user)) {
            return true;
        }

        return false;
    }

    public function canDeleteTracking(IdentityInterface $user, StudentAdscription $adscription)
    {
        if ($this->adscriptionIsOpen($adscription)) {
            if ($this->studentIsOwner($user, $adscription->student_id)) {
                return true;
            }

            if ($this->userIsAdmin($user)) {
                return true;
            }
        }

        return false;
    }

    public function canValidate(IdentityInterface $user, StudentAdscription $adscription)
    {
        if ($this->adscriptionIsClosed($adscription) && $this->userIsAdmin($user)) {
            return true;
        }

        return false;
    }

    public function canChangeStatus(IdentityInterface $user, StudentAdscription $adscription)
    {
        //if ($this->adscriptionIsClosed($adscription)) {
        //    return $this->canValidate($user, $adscription);
        //}

        return false;
    }

    protected function adscriptionIsOpen(StudentAdscription $adscription): bool
    {
        return $adscription->getStatus()?->is([AdscriptionStatus::OPEN]) ?? false;
    }

    protected function adscriptionIsClosed(StudentAdscription $adscription): bool
    {
        return $adscription->getStatus()?->is([AdscriptionStatus::CLOSED]) ?? false;
    }
}
