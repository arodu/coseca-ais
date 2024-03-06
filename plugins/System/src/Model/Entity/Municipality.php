<?php
declare(strict_types=1);

namespace System\Model\Entity;

use Cake\ORM\Entity;

/**
 * Municipality Entity
 *
 * @property int $municipality_id
 * @property int $state_id
 * @property string $name
 */
class Municipality extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'state_id' => true,
        'name' => true,
    ];
}
