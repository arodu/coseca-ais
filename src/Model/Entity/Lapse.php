<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Enum\Active;
use App\Model\Field\StageField;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\Entity;

/**
 * Lapse Entity
 *
 * @property int $id
 * @property string $name
 * @property bool $active
 * @property \Cake\I18n\Date $date
 *
 * @property \App\Model\Entity\StudentStage[] $student_stages
 */
class Lapse extends Entity
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
        'name' => true,
        'active' => true,
        'tenant_id' => true,
        'student_stages' => true,
    ];

    /**
     * @return string|null
     * @deprecated
     */
    protected function _getTenantName(): ?string
    {
        if (empty($this->tenant)) {
            return null;
        }

        return __('{0} ({1})', $this->tenant->label, $this->name);
    }

    /**
     * @var array
     */
    protected array $_virtual = [
        'label_active',
        'label',
    ];

    /**
     * @return string
     */
    protected function _getLabel(): string
    {
        if ($this->active) {
            return $this->name;
        }

        return __('{0} ({1})', $this->name, $this->label_active);
    }

    /**
     * @return string|null
     */
    protected function _getLabelActive(): ?string
    {
        return $this->getActive()?->label() ?? null;
    }

    /**
     * @return \App\Enum\Active
     */
    public function getActive(): Active
    {
        return Active::get($this->active ?? false);
    }

    /**
     * @param \App\Model\Field\StageField $stageField
     * @return \App\Model\Entity\LapseDate|null
     */
    public function getDates(StageField $stageField): ?LapseDate
    {
        if (empty($this->lapse_dates)) {
            throw new NotFoundException('Lapse dates not found');
        }

        foreach ($this->lapse_dates as $lapseDate) {
            if ($lapseDate->stage === $stageField->value) {
                return $lapseDate;
            }
        }

        return null;
    }
}
