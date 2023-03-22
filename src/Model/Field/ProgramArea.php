<?php

declare(strict_types=1);

namespace App\Model\Field;

use App\Enum\Trait\BasicEnumTrait;
use App\Enum\Trait\ListTrait;

enum ProgramArea: string
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
}
