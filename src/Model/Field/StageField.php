<?php
declare(strict_types=1);

namespace App\Model\Field;

use App\Enum\Trait\BasicEnumTrait;
use App\Enum\Trait\ListTrait;
use Cake\Core\Configure;

enum StageField: string
{
    use ListTrait;
    use BasicEnumTrait;

    case REGISTER = 'register';
    case COURSE = 'course';
    case ADSCRIPTION = 'adscription';
    case TRACKING = 'tracking';
    case ENDING = 'ending';
    case VALIDATION = 'validation';

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
     * @return StageField
     */
    public static function default(): StageField
    {
        return static::REGISTER;
    }
}
