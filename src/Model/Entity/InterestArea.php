<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InterestArea Entity
 *
 * @property int $id
 * @property int $program_id
 * @property string $name
 * @property string $description
 * @property bool $active
 *
 * @property \App\Model\Entity\Program $program
 */
class InterestArea extends Entity
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
    protected $_accessible = [
        'program_id' => true,
        'name' => true,
        'description' => true,
        'active' => true,
        'program' => true,
    ];
}
