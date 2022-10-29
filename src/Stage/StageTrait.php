<?php
declare(strict_types=1);

namespace App\Stage;

use App\Model\Entity\Student;
use App\Model\Entity\StudentStage;
use App\Model\Field\Stages;

trait StageTrait
{
    protected Student $_student;
    protected string $_key;

    /**
     * @param string $stageKey
     * @param Student $student
     */
    public function __construct(string $stageKey, Student $student)
    {
        $this->_key = $stageKey;
        $this->_student = $student;

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
        return $this->StudentStages->find([
                'student_id' => $this->student->id,
                'stage' => $this->getKey(),
            ])
            ->first();
    }

    /**
     * @return void
     */
    public function end()
    {
        $nextStage = Stages::getNextStage($this->getKey());
        $stage = StageFactory::getInstance($nextStage, $this->getStudent());
    }
}
