<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\StudentAdscription;
use App\Model\Field\AdscriptionStatus;
use Authentication\IdentityInterface;

class StudentAdscriptionPolicy
{
    use BasicChecksTrait;

    /**
     * @param \Authentication\IdentityInterface $user
     * @param \App\Model\Entity\StudentAdscription $adscription
     * @return \App\Policy\Result
     */
    public function canAddTracking(IdentityInterface $user, StudentAdscription $adscription)
    {
        $adscriptionIsOpen = $adscription->enum('status')?->is([AdscriptionStatus::OPEN]);

        if ($adscriptionIsOpen && $this->studentIsOwner($user, $adscription->student_id)) {
            return true;
        }

        if ($adscriptionIsOpen && $this->userIsAdmin($user)) {
            return true;
        }

        return false;
    }

    /**
     * @param \Authentication\IdentityInterface $user
     * @param \App\Model\Entity\StudentAdscription $adscription
     * @return bool
     */
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

    /**
     * @param \Authentication\IdentityInterface $user
     * @param \App\Model\Entity\StudentAdscription $adscription
     * @return bool
     */
    public function canValidate(IdentityInterface $user, StudentAdscription $adscription)
    {
        if ($this->adscriptionIsClosed($adscription) && $this->userIsAdmin($user)) {
            return true;
        }

        return false;
    }

    /**
     * Undocumented function
     *
     * @param \Authentication\IdentityInterface $user
     * @param \App\Model\Entity\StudentAdscription $adscription
     * @return bool
     */
    public function canChangeStatus(IdentityInterface $user, StudentAdscription $adscription)
    {
        // @todo not implement yet

        return false;
    }

    /**
     * @param \Authentication\IdentityInterface $user
     * @param \App\Model\Entity\StudentAdscription $adscription
     * @return bool
     */
    public function canClose(IdentityInterface $user, StudentAdscription $adscription)
    {
        if ($this->adscriptionIsOpen($adscription) && $this->userIsAdmin($user)) {
            return true;
        }

        if ($this->adscriptionIsOpen($adscription) && $this->studentIsOwner($user, $adscription->student_id)) {
            return true;
        }

        return false;
    }

    /**
     * @param \Authentication\IdentityInterface $user
     * @param \App\Model\Entity\StudentAdscription $adscription
     * @return bool
     */
    public function canPrintFormat007(IdentityInterface $user, StudentAdscription $adscription)
    {
        if ($this->adscriptionIsClosed($adscription) && $this->userIsAdmin($user)) {
            return true;
        }

        if (
            $this->adscriptionIsClosed($adscription)
            && $this->studentIsOwner($user, $adscription->student_id)
        ) {
            return true;
        }

        return false;
    }

    /**
     * @param \App\Model\Entity\StudentAdscription $adscription
     * @return bool
     */
    protected function adscriptionIsOpen(StudentAdscription $adscription): bool
    {
        return $adscription->enum('status')?->is([AdscriptionStatus::OPEN]) ?? false;
    }

    /**
     * @param \App\Model\Entity\StudentAdscription $adscription
     * @return bool
     */
    protected function adscriptionIsClosed(StudentAdscription $adscription): bool
    {
        return $adscription->enum('status')?->is([AdscriptionStatus::CLOSED]) ?? false;
    }
}
