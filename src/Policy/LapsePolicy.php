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

    protected function lapseDatesIsInProgress(Lapse $lapse, StageField $stage): bool
    {
        return $lapse?->getDates($stage)?->getStatus()?->is([StatusDate::IN_PROGRESS]) ?? false;
    }
}
