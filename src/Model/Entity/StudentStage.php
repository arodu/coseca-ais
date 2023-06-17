<?php

declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use Cake\ORM\Entity;

/**
 * StudentStage Entity
 *
 * @property int $id
 * @property int $student_id
 * @property string $stage
 * @property int $lapse_id
 * @property string $status
 * @property \Cake\I18n\FrozenTime $created
 * @property int $created_by
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $stage_label
 * @property string $status_label
 *
 * @property \App\Model\Entity\Student $student
 * @property \App\Model\Entity\Lapse $lapse
 */
class StudentStage extends Entity
{
    private StageField $_stageObj;
    private StageStatus $_stageStatusObj;

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
        'stage' => true,
        'status' => true,
        'parent_id' => true,
        'created' => true,
        'created_by' => true,
        'modified' => true,
        'modified_by' => true,
        'student' => true,
    ];

    protected $_virtual = [
        'stage_label',
        'status_label',
    ];

    /**
     * @return StageField|null
     */
    public function getStage(): ?StageField
    {
        return StageField::tryFrom($this->stage);
    }

    /**
     * @return StageStatus|null
     */
    public function getStatus(): ?StageStatus
    {
        return StageStatus::tryFrom($this->status);
    }

    protected function _getStageLabel(): string
    {
        return $this->getStage()?->label() ?? '';
    }

    protected function _getStatusLabel(): string
    {
        return $this->getStatus()?->label() ?? '';
    }
}
