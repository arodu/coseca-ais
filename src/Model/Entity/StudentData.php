<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StudentData Entity
 *
 * @property int $id
 * @property int $student_id
 * @property string|null $gender
 * @property string|null $phone
 * @property string|null $address
 * @property int|null $current_semester
 * @property int|null $uc
 * @property int|null $interest_area_id
 * @property string|null $observations
 *
 * @property \App\Model\Entity\Student $student
 */
class StudentData extends Entity
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
        'student_id' => true,
        'gender' => true,
        'phone' => true,
        'address' => true,
        'current_semester' => true,
        'uc' => true,
        'interest_area_id' => true,
        'observations' => true,
        'student' => true,
        'total_hours' => true,
    ];
}
