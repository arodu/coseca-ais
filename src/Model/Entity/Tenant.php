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
    protected $_accessible = [
        'lapses' => true,
        'students' => true,
        'tenant_filters' => true,
        'current_lapse' => true,
        'active' => true,
        'program' => true,
        'location' => true,
    ];

    /**
     * @return string
     */
    protected function _getLabel(): string
    {
        $output = [
            $this?->program?->name,
            $this?->location?->name,
        ];

        return implode(', ', array_filter($output));
    }

    /**
     * @return string
     */
    protected function _getAbbrLabel(): string
    {
        $output = [
            $this?->program?->abbr,
            $this?->location?->abbr,
        ];

        return implode('-', array_filter($output));
    }
}
