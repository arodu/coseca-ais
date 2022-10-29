<?php
declare(strict_types=1);

namespace App\Stage;

use App\Model\Entity\Student;
use App\Model\Entity\StudentStage;
use Cake\Datasource\EntityInterface;

interface StageInterface
{
    public function __construct(Student $student);
    public function initialize(): void;
    public function create(): StudentStage;
    public function getKey();
    public function getStudent(): Student;
    public function getStudentStage(): ?StudentStage;
    //public function show();

    public function end();
}
