<?php

declare(strict_types=1);

namespace App\Utility;

use App\Model\Entity\Student;

class FilePrint
{

    /**
     * @param \App\Model\Entity\Student $student
     * @return string
     */
    public static function format007(Student $student): string
    {
        if (empty($student->dni)) {
            throw new \InvalidArgumentException('El estudiante no tiene un DNI');
        }

        return h($student->dni) . '_planilla007.pdf';
    }

    /**
     * @param \App\Model\Entity\Student $student
     * @return string
     */
    public static function format009(Student $student): string
    {
        if (empty($student->dni)) {
            throw new \InvalidArgumentException('El estudiante no tiene un DNI');
        }

        return h($student->dni) . '_planilla009.pdf';
    }
}
