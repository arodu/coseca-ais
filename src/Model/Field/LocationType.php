<?php
declare(strict_types=1);

namespace App\Model\Field;

use CakeLteTools\Enum\ListInterface;
use CakeLteTools\Enum\Trait\BasicEnumTrait;
use CakeLteTools\Enum\Trait\ListTrait;

enum LocationType: string implements ListInterface
{
    use ListTrait;
    use BasicEnumTrait;

    case PRINCIPAL = 'principal';
    case NUCLEUS = 'nucleus';
    case EXTENSION = 'extension';

    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::PRINCIPAL => __('Principal'),
            self::NUCLEUS => __('Núcleo'),
            self::EXTENSION => __('Extensión'),
        };
    }
}
