<?php

declare(strict_types=1);

namespace App\Model\Entity;

use App\Enum\Active;
use App\Model\Field\StudentType;
use App\Utility\Stages;
use Cake\Http\Exception\NotFoundException;
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
        'created' => true,
        'created_by' => true,
        'modified' => true,
        'modified_by' => true,
        'user' => true,
        'tenant' => true,
        'student_stages' => true,
        'student_adscriptions' => true,
        'student_data' => true,
        'lapse_id' => true,
        'active' => true,
    ];

    protected $_virtual = [
        'dni',
        'first_name',
        'last_name',
        'email',
        'full_name',
        'type_label',
        'active_label',
    ];

    /**
     * @return string|null
     */
    protected function _getDni(): ?string
    {
        return $this->app_user->dni ?? null;
    }

    /**
     * @return string|null
     */
    protected function _getFirstName(): ?string
    {
        return $this->app_user->first_name ?? null;
    }

    /**
     * @return string|null
     */
    protected function _getLastName(): ?string
    {
        return $this->app_user->last_name ?? null;
    }

    /**
     * @return string|null
     */
    protected function _getFullName(): ?string
    {
        return implode(' ', [
            $this->first_name,
            $this->last_name,
        ]);
    }

    /**
     * @return string|null
     */
    protected function _getEmail(): ?string
    {
        return $this->app_user->email ?? null;
    }

    /**
     * @return string|null
     */
    protected function _getTypeLabel(): ?string
    {
        return $this->getType()?->label() ?? null;
    }

    /**
     * @return StudentType|null
     */
    public function getType(): ?StudentType
    {
        return StudentType::tryFrom($this->type);
    }

    /**
     * @return array
     */
    public function getStageFieldList(): array
    {
        return Stages::getStageFieldList($this->getType());
    }

    /**
     * @return Lapse
     */
    public function getCurrentLapse(): Lapse
    {
        if (!empty($this->lapse) && $this->lapse instanceof Lapse) {
            return $this->lapse;
        }

        if (!empty($this->tenant->current_lapse) && $this->tenant->current_lapse instanceof Lapse) {
            return $this->tenant->current_lapse;
        }

        throw new NotFoundException('student current_lapse not found');
    }

    /**
     * @return boolean
     */
    public function hasPrincipalAdscription(): bool
    {
        if (empty($this->student_adscriptions)) {
            return false;
        }

        foreach ($this->student_adscriptions as $studentAdscription) {
            if ($studentAdscription->principal ?? false) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return string|null
     */
    protected function _getActiveLabel(): ?string
    {
        return $this->getActive()?->label() ?? null;
    }

    /**
     * @return Active|null
     */
    public function getActive(): ?Active
    {
        return Active::get($this->active ?? false);
    }
}
