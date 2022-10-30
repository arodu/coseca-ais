<?php
declare(strict_types=1);

namespace App\Stage;

use App\Model\Entity\Student;
use App\Model\Entity\StudentStage;
use App\Model\Field\Stages;
use Cake\ORM\Locator\LocatorAwareTrait;

/** 
 * @property \App\Model\Table\StudentStagesTable $StudentStages
 */
trait StageTrait
{
    use LocatorAwareTrait;

    private int $studentId;
    private string $stageKey;

    protected ?Student $_student = null;
    protected ?StudentStage $_studentStage = null;
    protected ?string $lastError = null;

    /**
     * @param string $stageKey
     * @param integer $studentId
     */
    public function __construct(string $stageKey, int $studentId)
    {
        $this->stageKey = $stageKey;
        $this->studentId = $studentId;
        $this->StudentStages = $this->fetchTable('StudentStages');
        $this->initialize();
    }

    /**
     * @return string
     */
    public function getStageKey(): string
    {
        return $this->stageKey;
    }

    public function getNextStageKey(): string
    {
        return Stages::getNextStageKey($this->getStageKey());
    }

    /**
     * @return integer
     */
    public function getStudentId(): int
    {
        return $this->studentId;
    }

    /**
     * @param boolean $reset
     * @return Student|null
     */
    public function getStudent(bool $reset = false): ?Student
    {
        if ($reset || empty($this->_student)) {
            $this->_student = $this->StudentStages->Students->get($this->getStudentId());
        }

        return $this->_student;
    }

    /**
     * @param boolean $reset
     * @return StudentStage|null
     */
    public function getStudentStage(bool $reset = false): ?StudentStage
    {
        if ($reset || empty($this->_studentStage)) {
            $this->_studentStage = $this->StudentStages->find()
                ->where([
                    'studentId' => $this->getStudentId(),
                    'stage' => $this->getStageKey(),
                ])
                ->first();
        }

        return $this->_studentStage;
    }

    /**
     * @param string $stageStatus
     * @return void
     */
    public function changeStatus(string $stageStatus)
    {
        $studentStage = $this->getStudentStage();
        $studentStage->status = $stageStatus;
        $this->StudentStages->saveOrFail($studentStage);

        $this->_studentStage = $studentStage;
    }

    /**
     * @return string
     */
    public function getLastError(): string
    {
        return $this->_lastError;
    }

    /**
     * @param string $error
     * @return void
     */
    public function setLastError(string $error)
    {
        $this->_lastError = $error;
    }
}
