<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Field\LocationType;
use Cake\ORM\Entity;

/**
 * Location Entity
 *
 * @property int $id
 * @property string $name
 * @property string $abbr
 * @property string|null $type
 * @property \Cake\I18n\FrozenTime $created
 * @property string|null $created_by
 * @property \Cake\I18n\FrozenTime $modified
 * @property string|null $modified_by
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string|null $deleted_by
 *
 * @property \App\Model\Entity\Tenant[] $tenants
 */
class Location extends Entity
{
    use Traits\EnumFieldTrait;

    /**
     * @var array
     */
    protected $enumFields = [
        'type' => LocationType::class,
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
        'name' => true,
        'abbr' => true,
        'type' => true,
        'created' => true,
        'created_by' => true,
        'modified' => true,
        'modified_by' => true,
        'deleted' => true,
        'deleted_by' => true,
        'tenants' => true,
    ];

    protected $_virtual = ['type_label'];

    public function _getTypeLabel(): string
    {
        return $this->enum('type')?->label() ?? '';
    }
}
