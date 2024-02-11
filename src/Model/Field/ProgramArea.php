<?php
declare(strict_types=1);

namespace App\Model\Field;

use CakeLteTools\Enum\ListInterface;
use CakeLteTools\Enum\Trait\BasicEnumTrait;
use CakeLteTools\Enum\Trait\ListTrait;

enum ProgramArea: string implements ListInterface
{
    use ListTrait;
    use BasicEnumTrait;

    case ACES = 'aces';
    case AIS = 'ais';
    case AIAT = 'aiat';
    case ACPJ = 'acpj';
    case SALUD = 'salud';
    case ODO = 'odo';
    case AIA = 'aia';
    case VET = 'vet';
    case EDU = 'edu';

    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            static::ACES => __('ACES'),
            static::AIS => __('AIS'),
            static::AIAT => __('AIAT'),
            static::ACPJ => __('ACPJ'),
            static::SALUD => __('SALUD'),
            static::ODO => __('ODO'),
            static::AIA => __('AIA'),
            static::VET => __('VET'),
            static::EDU => __('EDU'),
            default => __('NaN'),
        };
    }

    /**
     * @return string
     */
    public function printLabel(): string
    {
        return match ($this) {
            static::ACES => __('ACES'),
            static::AIS => __('Área de Ingeniería de Sistemas'),
            static::AIAT => __('AIAT'),
            static::ACPJ => __('ACPJ'),
            static::SALUD => __('SALUD'),
            static::ODO => __('ODO'),
            static::AIA => __('AIA'),
            static::VET => __('VET'),
            static::EDU => __('EDU'),
            default => __('NaN'),
        };
    }
}
