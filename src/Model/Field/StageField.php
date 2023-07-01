<?php
declare(strict_types=1);

namespace App\Model\Field;

use Cake\Core\Configure;
use CakeLteTools\Enum\ListInterface;
use CakeLteTools\Enum\Trait\BasicEnumTrait;
use CakeLteTools\Enum\Trait\ListTrait;

enum StageField: string implements ListInterface
{
    use ListTrait;
    use BasicEnumTrait;

    case REGISTER = 'register';
    case COURSE = 'course';
    case ADSCRIPTION = 'adscription';
    case TRACKING = 'tracking';
    case RESULTS = 'results';
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
