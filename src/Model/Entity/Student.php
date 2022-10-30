<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Field\Stages;
use App\Stage\StageFactory;
use App\Stage\StageInterface;
use Cake\Log\Log;
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
        'dni' => true,
        'created' => true,
        'created_by' => true,
        'modified' => true,
        'modified_by' => true,
        'app_user' => true,
        'student_stages' => true,
    ];

    protected $_virtual = [
        'first_name',
        'last_name',
        'email',
    ];

    protected function _getFirstName()
    {
        if (empty($this->app_user)) {
            Log::alert('AppUser not loaded on StudentEntity');
            return null;
        }

        return $this->app_user->first_name;
    }

    protected function _getLastName()
    {
        if (empty($this->app_user)) {
            Log::alert('AppUser not loaded on StudentEntity');
            return null;
        }

        return $this->app_user->last_name;
    }

    protected function _getEmail()
    {
        if (empty($this->app_user)) {
            Log::alert('AppUser not loaded on StudentEntity');
            return null;
        }

        return $this->app_user->email;
    }

    /**
     * @return string
     */
    public function getCurrentStageKey(): string
    {
        // @todo buscar el StudentStage actual

        return Stages::STAGE_REGISTER;
    }
}
