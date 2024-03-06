<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Field\ProgramArea;
use App\Model\Field\ProgramRegime;
use Cake\ORM\Entity;

/**
 * Program Entity
 *
 * @property int $id
 * @property string $name
 * @property string $area
 * @property string $regime
 * @property string $abbr
 *
 * @property \App\Model\Entity\Tenant[] $tenants
 */
class Program extends Entity
{
    use Traits\EnumFieldTrait;

    /**
     * @var array
     */
    protected array $enumFields = [
        'area' => ProgramArea::class,
        'regime' => ProgramRegime::class,
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
    protected array $_accessible = [
        'name' => true,
        'area' => true,
        'regime' => true,
        'abbr' => true,
        'tenants' => true,
    ];

    protected array $_virtual = [
        'area_label',
        'regime_label',
    ];

    /**
     * @return string|null
     */
    protected function _getAreaLabel(): ?string
    {
        return $this->enum('area')?->label() ?? null;
    }

    /**
     * @return string|null
     */
    protected function _getRegimeLabel(): ?string
    {
        return $this->enum('regime')?->label() ?? null;
    }

    /**
     * area_print_label
     *
     * @return string|null
     */
    protected function _getAreaPrintLabel(): ?string
    {
        return $this->enum('area')?->printLabel() ?? null;
    }

    /**
     * area_print_logo
     *
     * @return string|null
     */
    protected function _getAreaPrintLogo(): ?string
    {
        return $this->enum('area')?->printLogo() ?? null;
    }
}
