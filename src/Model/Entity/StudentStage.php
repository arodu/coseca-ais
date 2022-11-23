<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Stage\StageFactory;
use App\Stage\StageInterface;
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
 * @property int $modified_by
 *
 * @property \App\Model\Entity\Student $student
 * @property \App\Model\Entity\Lapse $lapse
 */
class StudentStage extends Entity
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
        'stage' => true,
        'lapse_id' => true,
        'status' => true,
        'created' => true,
        'created_by' => true,
        'modified' => true,
        'modified_by' => true,
        'student' => true,
        'lapse' => true,
    ];

    protected $_virtual = [
        'stage_label',
        'status_label',
    ];

    protected function _getStageLabel(): string
    {
        return $this->getStageField()->label();
    }

    protected function _getStatusLabel(): string
    {
        return $this->getStatus()->label();
    }

    private StageInterface $_stageInstance;

    /**
     * @return StageInterface
     */
    public function getStageInstance(): StageInterface
    {
        if (empty($this->_stageInstance)) {
            $this->_stageInstance = StageFactory::getInstance($this);
        }

        return $this->_stageInstance;
    }

    private StageField $_stageField;

    /**
     * @return StageField
     */
    public function getStageField(): StageField
    {
        if (empty($this->_stageField)) {
            $this->_stageField = StageField::from($this->stage);
        }

        return $this->_stageField;
    }

    private StageStatus $_stageStatus;

    /**
     * @return StageStatus
     */
    public function getStatus(): StageStatus
    {
        if (empty($this->_stageStatus)) {
            $this->_stageStatus = StageStatus::from($this->status);
        }

        return $this->_stageStatus;
    }
}
