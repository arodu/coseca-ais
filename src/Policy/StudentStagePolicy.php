<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\StudentStage;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Model\Field\UserRole;
use Authentication\IdentityInterface;

class StudentStagePolicy
{
    use BasicChecksTrait;

    public function canRegisterEdit(IdentityInterface $user, StudentStage $studentStage)
    {
        if (!$this->stageIsRegister($studentStage)) {
            return false;
        }

        if ($this->userIsAdmin($user)) {
            return true;
        }

        if ($this->studentIsOwner($user, $studentStage->student_id) && $this->stageStatusIsInProgress($studentStage)) {
            return true;
        }

        return false;
    }

    public function canRegisterValidate(IdentityInterface $user, StudentStage $studentStage)
    {
        if (!$this->stageIsRegister($studentStage)) {
            return false;
        }

        if ($this->userIsAdmin($user)) {
            return true;
        }

        return false;
    }

    public function canCourseEdit(IdentityInterface $user, StudentStage $studentStage)
    {
        if (!$this->stageIsCourse($studentStage)) {
            return false;
        }

        if ($this->userIsAdmin($user) && $this->stageIsCourse($studentStage)) {
            return true;
        }

        return false;
    }
    
    public function canCourseValidate(IdentityInterface $user, StudentStage $studentStage)
    {
        if (!$this->stageIsCourse($studentStage)) {
            return false;
        }

        if ($this->userIsAdmin($user)) {
            return true;
        }

        return false;
    }

    protected function stageIsRegister(StudentStage $studentStage): bool
    {
        return $studentStage->stage_obj->is(StageField::REGISTER);
    }

    protected function stageIsCourse(StudentStage $studentStage): bool
    {
        return $studentStage->stage_obj->is(StageField::COURSE);
    }

    protected function stageStatusIsInProgress(StudentStage $studentStage): bool
    {
        return $studentStage->status_obj->is(StageStatus::IN_PROGRESS);
    }
}
