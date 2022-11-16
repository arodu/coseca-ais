<?php
declare(strict_types=1);

namespace App\Enum;

use App\Enum\Trait\ListTrait;
use Cake\Core\Configure;

enum StageField: string
{
    use ListTrait;

    case REGISTER = 'register';
    case COURSE = 'course';
    case ADSCRIPTION = 'adscription';
    case TRACKING = 'tracking';
    case ENDING = 'ending';
    case VALIDATION = 'validation';

    /**
     * @param StudentType $studentType
     * @return array
     */
    public static function casesByStudentType(StudentType $studentType): array
    {
        return match($studentType) {
            StudentType::VALIDATED => [
                    static::REGISTER,
                    static::VALIDATION,
            ],
            StudentType::REGULAR => [
                    static::REGISTER,
                    static::COURSE,
                    static::ADSCRIPTION,
                    static::TRACKING,
                    static::ENDING,
            ],
        };
    }

    /**
     * @return string
     */
    public function label(): string
    {
        $stages = Configure::read('Stages');

        return $stages[$this->value]['label'];
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        $stages = Configure::read('Stages');

        return $stages[$this->value]['class'];
    }

    /**
     * @return StageStatus
     */
    public function getDefaultStatus(): StageStatus
    {
        $stages = Configure::read('Stages');

        return $stages[$this->value]['status'];
    }

    /**
     * @return array
     */
    public function info(): array
    {
        $stages = Configure::read('Stages');

        return $stages[$this->value];
    }

    /**
     * @return Stage
     */
    public static function default(): Stage
    {
        return static::REGISTER;
    }
}
