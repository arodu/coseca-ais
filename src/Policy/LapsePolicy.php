<?php
declare(strict_types=1);

namespace App\Policy;

use App\Enum\StatusDate;
use App\Model\Entity\Lapse;
use App\Model\Field\StageField;
use Authentication\IdentityInterface;

class LapsePolicy
{
    use BasicChecksTrait;

    /**
     * @param \Authentication\IdentityInterface $user
     * @param \App\Model\Entity\Lapse $lapse
     * @return bool
     */
    public function canRegisterEdit(IdentityInterface $user, Lapse $lapse)
    {
        if ($this->userIsAdmin($user)) {
            return true;
        }

        if ($this->lapseDatesIsInProgress($lapse, StageField::REGISTER)) {
            return true;
        }

        return false;
    }

    /**
     * @param \App\Model\Entity\Lapse $lapse
     * @param \App\Model\Field\StageField $stage
     * @return bool
     */
    protected function lapseDatesIsInProgress(Lapse $lapse, StageField $stage): bool
    {
        return $lapse?->getDates($stage)?->getStatus()?->is([StatusDate::IN_PROGRESS]) ?? false;
    }
}
