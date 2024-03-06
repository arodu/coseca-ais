<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tenant Entity
 *
 * @property int $id
 * @property string $name
 * @property string $abbr
 * @property int $regime
 * @property bool $active
 * @property int $current_lapse
 * @property int $program_id
 *
 * @property \App\Model\Entity\Lapse[] $lapses
 * @property \App\Model\Entity\Student[] $students
 * @property \App\Model\Entity\TenantFilter[] $tenant_filters
 */
class Tenant extends Entity
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
        'abbr' => true,
        'lapses' => true,
        'students' => true,
        'tenant_filters' => true,
        'regime' => true,
        'active' => true,
        'current_lapse' => true,
        'program_id' => true,
    ];

    protected array $_virtual = [
        'label',
        'abbr_label',
    ];

    /**
     * @return string
     */
    protected function _getLabel(): string
    {
        if (!$this->program) {
            return $this->name;
        }

        return $this->program->name . ', ' . $this->name;
    }

    /**
     * @return string
     */
    protected function _getAbbrLabel(): string
    {
        if (!$this->program) {
            return $this->abbr;
        }

        return $this->program->abbr . '-' . $this->abbr;
    }
}
