<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\StudentStage;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Utility\Calc;
use Authentication\IdentityInterface;
use Authorization\Policy\Result;
use Cake\ORM\Locator\LocatorAwareTrait;

class StudentStagePolicy
{
    use BasicChecksTrait;
    use LocatorAwareTrait;

    /**
     * @param \Authentication\IdentityInterface $user
     * @param \App\Model\Entity\StudentStage $studentStage
     * @return bool
     */
    public function canRegisterEdit(IdentityInterface $user, StudentStage $studentStage): bool
    {
        if (!$this->stageIs($studentStage, StageField::REGISTER)) {
            return false;
        }

        if ($this->userIsAdmin($user)) {
            return true;
        }

        if ($this->studentIsOwner($user, $studentStage->student_id) && $this->stageStatusIs($studentStage, StageStatus::IN_PROGRESS)) {
            return true;
        }

        return false;
    }

    /**
     * @param \Authentication\IdentityInterface $user
     * @param \App\Model\Entity\StudentStage $studentStage
     * @return bool
     */
    public function canRegisterValidate(IdentityInterface $user, StudentStage $studentStage): bool
    {
        if (!$this->stageIs($studentStage, StageField::REGISTER)) {
            return false;
        }

        if ($this->userIsAdmin($user)) {
            return true;
        }

        return false;
    }

    /**
     * @param \Authentication\IdentityInterface $user
     * @param \App\Model\Entity\StudentStage $studentStage
     * @return bool
     */
    public function canCourseEdit(IdentityInterface $user, StudentStage $studentStage): bool
    {
        if (!$this->stageIs($studentStage, StageField::COURSE)) {
            return false;
        }

        if ($this->userIsAdmin($user)) {
            return true;
        }

        return false;
    }

    /**
     * @param \Authentication\IdentityInterface $user
     * @param \App\Model\Entity\StudentStage $studentStage
     * @return bool
     */
    public function canCourseValidate(IdentityInterface $user, StudentStage $studentStage): bool
    {
        if (!$this->stageIs($studentStage, StageField::COURSE)) {
            return false;
        }

        if ($this->userIsAdmin($user)) {
            return true;
        }

        return false;
    }

    /**
     * @param \Authentication\IdentityInterface $user
     * @param \App\Model\Entity\StudentStage $studentStage
     * @return \Authorization\Policy\Result
     */
    public function canClose(IdentityInterface $user, StudentStage $studentStage): Result
    {
        if ($this->userIsStudent($user) && !$this->studentIsOwner($user, $studentStage->student_id)) {
            return new Result(false, __('You are not the owner of this stage'));
        }

        if ($this->stageIs($studentStage, StageField::TRACKING, StageStatus::IN_PROGRESS)) {
            if (!empty($studentStage->student)) {
                $totalHours = $studentStage->student?->total_hours ?? 0;
            } else {
                $student = $this->fetchTable('Students')->get($studentStage->student_id);
                $totalHours = $student?->total_hours ?? 0;
            }

            if (($totalHours ?? 0) < Calc::getTotalHours()) {
                return new Result(false, __('The student has not completed the required hours ({0}h)', Calc::getTotalHours()));
            }

            // @todo verificar que tiene un proyecto por defecto

            return new Result(true);
        }

        return new Result(false, __('stage {0} does not allow closing', $studentStage->stage_label));
    }

    /**
     * @param \Authentication\IdentityInterface $user
     * @param \App\Model\Entity\StudentStage $studentStage
     * @return \Authorization\Policy\Result
     */
    public function canValidate(IdentityInterface $user, StudentStage $studentStage): Result
    {
        if (!$this->userIsAdmin($user)) {
            return new Result(false, __('only admins can validate a stage'));
        }

        if ($this->stageIs($studentStage, StageField::TRACKING, StageStatus::REVIEW)) {
            return new Result(true);
        }

        if ($this->stageIs($studentStage, StageField::ENDING, StageStatus::REVIEW)) {
            return new Result(true);
        }

        return new Result(false, __('stage {0} does not allow validation', $studentStage->stage_label));
    }

    /**
     * @param \Authentication\IdentityInterface $user
     * @param \App\Model\Entity\StudentStage $studentStage
     * @return \Authorization\Policy\Result
     */
    public function canPrint(IdentityInterface $user, StudentStage $studentStage): Result
    {
        if ($this->userIsStudent($user)) {
            if (!$this->studentIsOwner($user, $studentStage->student_id)) {
                return new Result(false, __('You are not the owner of this stage'));
            }

            if ($this->stageIs($studentStage, StageField::TRACKING, StageStatus::REVIEW)) {
                // print 007
                return new Result(true);
            }

            if ($this->stageIs($studentStage, StageField::ENDING, StageStatus::REVIEW)) {
                // print 009
                return new Result(true);
            }
        }

        if ($this->userIsAdmin($user)) {
            if ($this->stageIs($studentStage, StageField::TRACKING, [StageStatus::REVIEW, StageStatus::SUCCESS])) {
                // print 007
                return new Result(true);
            }

            if ($this->stageIs($studentStage, StageField::ENDING, [StageStatus::REVIEW, StageStatus::SUCCESS])) {
                // print 009
                return new Result(true);
            }
        }

        return new Result(false, __('stage {0} does not allow printing', $studentStage->stage_label));
    }

    /**
     * @param \Authentication\IdentityInterface $user
     * @param \App\Model\Entity\StudentStage $studentStage
     * @return \Authorization\Policy\Result
     */
    public function canDisplayActions(IdentityInterface $user, StudentStage $studentStage): bool
    {
        if ($this->canPrint($user, $studentStage)->getStatus()) {
            return true;
        }

        if ($this->canClose($user, $studentStage)->getStatus()) {
            return true;
        }

        return false;
    }

    /**
     * @param \App\Model\Entity\StudentStage $studentStage
     * @param \App\Model\Field\StageField $stageField
     * @param \App\Model\Field\StageStatus|array|null $stageStatus
     * @return bool
     */
    protected function stageIs(StudentStage $studentStage, StageField $stageField, StageStatus|array|null $stageStatus = null): bool
    {
        $isStageField = $studentStage->enum('stage')?->is($stageField) ?? false;

        if (empty($stageStatus)) {
            return $isStageField;
        }

        return $isStageField && $this->stageStatusIs($studentStage, $stageStatus);
    }

    /**
     * @param \App\Model\Entity\StudentStage $studentStage
     * @param \App\Model\Field\StageStatus $stageStatus
     * @return bool
     */
    protected function stageStatusIs(StudentStage $studentStage, StageStatus|array $stageStatus): bool
    {
        return $studentStage->enum('status')?->is($stageStatus) ?? false;
    }
}
