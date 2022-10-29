<?php
declare(strict_types=1);

namespace App\Stage;

use App\Model\Entity\Student;
use App\Model\Entity\StudentStage;
use Cake\ORM\Locator\LocatorAwareTrait;

trait StageTrait
{
    use LocatorAwareTrait;

    protected Student $_student;
    protected string $_key;
    protected string $_lastError;

    /**
     * @param string $stageKey
     * @param Student $student
     */
    public function __construct(string $stageKey, Student $student)
    {
        $this->_key = $stageKey;
        $this->_student = $student;

        /** @var \App\Model\Table\StudentStagesTable $StudentStages */
        $this->StudentStages = $this->fetchTable('StudentStages');

        $this->initialize();
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->_key;
    }

    /**
     * @return Student
     */
    public function getStudent(): Student
    {
        return $this->_student;
    }

    /**
     * @return StudentStage|null
     */
    public function getStudentStage(): ?StudentStage
    {
        return $this->StudentStages->find()
            ->where([
                'student_id' => $this->getStudent()->id,
                'stage' => $this->getKey(),
            ])
            ->first();
    }

    public function getLastError(): string
    {
        return $this->_lastError;
    }

    public function setLastError(string $error)
    {
        $this->_lastError = $error;
    }
}
