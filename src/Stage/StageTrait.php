<?php
declare(strict_types=1);

namespace App\Stage;

use App\Model\Entity\Student;

trait StageTrait
{
    public Student $student;   

    public function __construct(Student $student)
    {
        $this->student = $student;
    }
}
