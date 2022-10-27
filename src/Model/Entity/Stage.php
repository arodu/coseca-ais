<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Stage Entity
 *
 * @property int $id
 * @property string $name
 * @property int $position
 * @property bool $active
 * @property string $code
 *
 * @property \App\Model\Entity\StudentStage[] $student_stages
 */
class Stage extends Entity
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
        'name' => true,
        'position' => true,
        'active' => true,
        'code' => true,
        'student_stages' => true,
    ];
}
