<?php
declare(strict_types=1);

namespace App\Stage;

use App\Model\Entity\Student;
use App\Model\Entity\StudentStage;
use App\Model\Field\StageField;
use Cake\ORM\Locator\LocatorAwareTrait;
use InvalidArgumentException;

/** 
 * @property \App\Model\Table\StudentStagesTable $StudentStages
 */
trait StageTrait
{
    use LocatorAwareTrait;

    private int $studentId;
    private StageField $stageField;

    protected ?Student $_student = null;
    protected ?StudentStage $_studentStage = null;
    protected ?string $lastError = null;

    /**
     * @param StudentStage $studentStage
     */
    public function __construct(StudentStage $studentStage)
    {
        if (empty($studentStage->stage)) {
            throw new InvalidArgumentException();
        }

        if (empty($studentStage->student_id)) {
            throw new InvalidArgumentException();
        }

        $this->_studentStage = $studentStage;
        $this->stageField = $this->_studentStage->getStageField();
        $this->studentId = $this->_studentStage->student_id;
        $this->StudentStages = $this->fetchTable('StudentStages');
        $this->initialize();
    }

    /**
     * @return StageField
     */
    public function getStageField(): StageField
    {
        return $this->stageField;
    }

    /**
     * @return StageField
     */
    public function getNextStageField(): StageField
    {
        //return Stages::getNextStageKey($this->getStageKey(), $this->getStudent()->type);
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
            $this->_student = $this->StudentStages->Students
                ->find('complete')
                ->where([$this->StudentStages->Students->aliasField('id') => $this->getStudentId()])
                ->first();
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
                    'student_id' => $this->getStudentId(),
                    'stage' => $this->getStageKey(),
                ])
                ->first();
        }

        return $this->_studentStage;
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
