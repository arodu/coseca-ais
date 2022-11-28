<?php
declare(strict_types=1);

namespace App\Stage;

use App\Model\Entity\Student;
use App\Model\Entity\StudentStage;
use App\Model\Field\StageField;
use App\Utility\Stages;
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
        $this->LapseDates = $this->fetchTable('LapseDates');
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
        return Stages::getNextStageField($this->getStageField(), $this->getStudent()->getType());
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


    public function getDates(): array
    {
        $lapseDates = $this->LapseDates->find()
            ->where([
                'lapse_id' => $this->getStudentStage()->lapse_id,
                'code' => $this->getStageField()->value,
            ])
            ->first();

        return [
            'start_date' => $lapseDates->start_date,
            'end_date' => $lapseDates->end_date,
        ];
    }
}
