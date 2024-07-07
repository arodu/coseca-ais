<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Entity\Traits\EnumFieldTrait;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Utility\CacheRequest;
use Cake\ORM\Entity;
use Cake\ORM\Locator\LocatorAwareTrait;

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
    use EnumFieldTrait;
    use LocatorAwareTrait;

    /**
     * Fields that are enum fields.
     *
     * @var array<string, string>
     */
    protected $enumFields = [
        'stage' => StageField::class,
        'status' => StageStatus::class,
    ];

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
     * @param mixed $item
     * @return bool
     */
    public function statusIs(mixed $item): bool
    {
        return $this->enum('status')?->is($item) ?? false;
    }

    /**
     * @return string
     */
    protected function _getStageLabel(): string
    {
        return $this->enum('stage')?->label() ?? '';
    }

    /**
     * @return string
     */
    protected function _getStatusLabel(): string
    {
        return $this->enum('status')?->label() ?? '';
    }

    /**
     * @return \App\Model\Entity\Student
     */
    public function getStudentEntity(): Student
    {
        if (!empty($this->student) && $this->student instanceof Student) {
            return $this->student;
        }

        return CacheRequest::remember('student' . $this->student_id, function () {
            return $this->fetchTable('Students')->get($this->student_id);
        });
    }
}
