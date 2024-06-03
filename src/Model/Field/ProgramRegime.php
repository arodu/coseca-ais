<?php
declare(strict_types=1);

namespace App\Model\Field;

use CakeLteTools\Enum\ListInterface;
use CakeLteTools\Enum\Trait\BasicEnumTrait;
use CakeLteTools\Enum\Trait\ListTrait;

enum ProgramRegime: string implements ListInterface
{
    use ListTrait;
    use BasicEnumTrait;

    case BIANNUAL = 'biannual';
    case QUARTERLY = 'quarterly';
    case ANNUALIZED_5 = 'annualized_5';
    case ANNUALIZED_6 = 'annualized_6';

    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            static::BIANNUAL => __('Semestral'),
            static::QUARTERLY => __('Trimestral'),
            static::ANNUALIZED_5 => __('Anualizado (5 años)'),
            static::ANNUALIZED_6 => __('Anualizado (6 años)'),
            default => __('NaN'),
        };
    }

    /**
     * @return string
     */
    public function formLabel(): string
    {
        return match ($this) {
            static::BIANNUAL => __('Semestre'),
            static::QUARTERLY => __('Trimestre'),
            static::ANNUALIZED_5 => __('Año'),
            static::ANNUALIZED_6 => __('Año'),
            default => __('NaN'),
        };
    }

    /**
     * @return int
     */
    public function maxLevel(): int
    {
        return match ($this) {
            static::BIANNUAL => 10,
            static::QUARTERLY => 15,
            static::ANNUALIZED_5 => 5,
            static::ANNUALIZED_6 => 6,
            default => 0,
        };
    }

    /**
     * @return array
     */
    public function creditTypeLabel(): array
    {
        return match ($this) {
            static::BIANNUAL, static::QUARTERLY => ['render' => 'render', 'label' => 'Numero de Unidades de Credito Aprobadas'],
            static::ANNUALIZED_5, static::ANNUALIZED_6 => [],
            default => __('NaN'),
        };
    }
}
