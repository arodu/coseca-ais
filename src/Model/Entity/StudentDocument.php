<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StudentDocument Entity
 *
 * @property int $id
 * @property int $student_id
 * @property string $type
 * @property string $token
 * @property string $model
 * @property int $foreign_key
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Student $student
 * @property \App\Model\Entity\StudentAdscription[] $student_adscriptions
 */
class StudentDocument extends Entity
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
        'student_id' => true,
        'type' => true,
        'token' => true,
        'model' => true,
        'foreign_key' => true,
        'created' => true,
        'modified' => true,
        'student' => true,
        'student_adscriptions' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected array $_hidden = [
        'token',
    ];
}
