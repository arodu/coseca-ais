<?php

declare(strict_types=1);

namespace App\Enum;

use Cake\Datasource\EntityInterface;
use CakeLteTools\Enum\BadgeInterface;
use CakeLteTools\Enum\Color;
use CakeLteTools\Enum\ListInterface;
use CakeLteTools\Enum\Trait\ListTrait;

enum RecordStatus: string implements ListInterface, BadgeInterface
{
    use ListTrait;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case DELETED = 'deleted';

    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            static::ACTIVE => __('Ativo'),
            static::INACTIVE => __('Inativo'),
            static::DELETED => __('Eliminado'),

            default => __('NaN'),
        };
    }

    /**
     * @return \CakeLteTools\Enum\Color
     */
    public function color(): Color
    {
        return match ($this) {
            static::ACTIVE => Color::PRIMARY,
            static::INACTIVE => Color::WARNING,
            static::DELETED => Color::DANGER,
        };
    }

    public static function get(EntityInterface $entity, array $options = []): self
    {
        $options = array_merge([
            'activeField' => 'active',
            'deletedField' => 'deleted',
        ], $options);

        if (!$entity->has($options['activeField']) || !$entity->has($options['deletedField'])) {
            throw new \InvalidArgumentException('The entity must have the active and deleted fields');
        }

        if ($entity->get($options['deletedField']) !== null) {
            return static::DELETED;
        }

        return match (true) {
            $entity->get($options['activeField']) === true => static::ACTIVE,
            default => static::INACTIVE,
        };
    }
}
