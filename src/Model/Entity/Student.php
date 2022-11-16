<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Enum\StudentType;
use App\Model\Field\Stages;
use Cake\ORM\Entity;

/**
 * Student Entity
 *
 * @property int $id
 * @property string $user_id
 * @property \Cake\I18n\FrozenTime $created
 * @property int $created_by
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $modified_by
 *
 * @property \App\Model\Entity\AppUser $app_user
 * @property \App\Model\Entity\StudentStage[] $student_stages
 */
class Student extends Entity
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
        'user_id' => true,
        'tenant_id' => true,
        'type' => true,
        'dni' => true,
        'created' => true,
        'created_by' => true,
        'modified' => true,
        'modified_by' => true,
        'gender' => true,
        'phone' => true,
        'address' => true,
        'current_semester' => true,
        'uc' => true,
        'areas' => true,
        'observations' => true,
        'user' => true,
        'tenant' => true,
        'student_stages' => true,
    ];

    protected $_virtual = [
        'first_name',
        'last_name',
        'email',
        'full_name'
    ];

    protected function _getFirstName()
    {
        return $this->app_user->first_name ?? null;
    }

    protected function _getLastName()
    {
        return $this->app_user->last_name ?? null;
    }

    protected function _getFullName()
    {
        return implode(' ', [
            $this->first_name,
            $this->last_name,
        ]);
    }

    protected function _getEmail()
    {
        return $this->app_user->email ?? null;
    }

    protected function _getType($type): StudentType
    {
        return StudentType::from($type);
    }
}
