<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StudentTracking Entity
 *
 * @property int $id
 * @property int $student_adscription_id
 * @property \Cake\I18n\FrozenDate $date
 * @property float $hours
 * @property string $description
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\StudentAdscription $student_adscription
 */
class StudentTracking extends Entity
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
        'student_adscription_id' => true,
        'date' => true,
        'hours' => true,
        'description' => true,
        'created' => true,
        'student_adscription' => true,
    ];
}
