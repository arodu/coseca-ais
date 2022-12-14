<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StudentAdscription Entity
 *
 * @property int $id
 * @property int $student_id
 * @property int $project_id
 * @property int $lapse_id
 * @property int $tutor_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Student $student
 * @property \App\Model\Entity\Project $project
 * @property \App\Model\Entity\Lapse $lapse
 * @property \App\Model\Entity\Tutor $tutor
 */
class StudentAdscription extends Entity
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
        'project_id' => true,
        'lapse_id' => true,
        'tutor_id' => true,
        'created' => true,
        'modified' => true,
        'student' => true,
        'project' => true,
        'lapse' => true,
        'tutor' => true,
    ];
}
