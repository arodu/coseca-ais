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
        return static::format('planilla007', $student);
    }

    /**
     * @param \App\Model\Entity\Student $student
     * @return string
     */
    public static function format009(Student $student): string
    {
        return static::format('planilla009', $student);
    }

    /**
     * @param string $format
     * @param \App\Model\Entity\Student $student
     * @return string
     */
    public static function format(string $format, Student $student): string
    {
        if (empty($student->dni)) {
            throw new \InvalidArgumentException('El estudiante no tiene un DNI');
        }

        return h($student->dni) . '_' . $format . '.pdf';
    }
}
