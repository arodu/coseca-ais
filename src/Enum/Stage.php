<?php
declare(strict_types=1);

namespace App\Enum;

use App\Enum\Trait\ListTrait;
use Cake\Core\Configure;

enum Stage: string
{
    use ListTrait;

    case REGISTER = 'register';
    case COURSE = 'course';
    case ADSCRIPTION = 'adscription';
    case TRACKING = 'tracking';
    case ENDING = 'ending';
    case VALIDATION = 'validation';

    public function label(): string
    {
        $stages = Configure::read('Stages');

        return $stages[$this->value]['label'];
    }

    public function getClass(): string
    {
        $stages = Configure::read('Stages');

        return $stages[$this->value]['class'];
    }

    public function getDefaultStatus(): StageStatus
    {
        $stages = Configure::read('Stages');

        return $stages[$this->value]['status'];
    }

    public function info(): array
    {
        $stages = Configure::read('Stages');

        return $stages[$this->value];
    }

    public static function default(): Stage
    {
        return static::REGISTER;
    }
}
