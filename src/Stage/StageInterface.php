<?php
declare(strict_types=1);

namespace App\Stage;

use App\Model\Entity\Student;
use App\Model\Entity\StudentStage;
use Cake\Datasource\EntityInterface;

interface StageInterface
{
    public function __construct(Student $student);
    public function create(): StudentStage;
    //public function show();
    //public function finalize();
    
}
