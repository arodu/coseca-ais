<?php
declare(strict_types=1);

namespace App\Stage;

use App\Model\Entity\Student;
use App\Model\Entity\StudentStage;
use Cake\Datasource\EntityInterface;

interface StageInterface
{
    public function __construct(string $stageKey, Student $student);
    public function initialize(): void;
    public function create(): StudentStage;
    public function getKey();
    public function getStudent(): Student;
    public function getStudentStage(): ?StudentStage;
    public function close(string $status);
    public function getLastError(): string;
    public function setLastError(string $error);
}
