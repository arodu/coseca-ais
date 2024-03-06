<?php
declare(strict_types=1);

namespace System\Model\Entity;

use Cake\ORM\Entity;

/**
 * State Entity
 *
 * @property int $state_id
 * @property string $name
 * @property string $iso
 */
class State extends Entity
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
        'name' => true,
        'iso' => true,
    ];
}
