<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Enum\Active;
use Cake\ORM\Entity;

/**
 * Lapse Entity
 *
 * @property int $id
 * @property string $name
 * @property bool $active
 * @property \Cake\I18n\FrozenDate $date
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
    protected $_accessible = [
        'name' => true,
        'active' => true,
        'tenant_id' => true,
        'student_stages' => true,
    ];

    protected function _getTenantName()
    {
        if (empty($this->tenant)) {
            return null;
        }

        return __('{0} ({1})', $this->tenant->name, $this->name);
    }

    protected $_virtual = [
        'label_active',
    ];

    protected function _getLabelActive()
    {
        return $this->getActive()->label();
    }

    private Active $_active;

    public function getActive(): Active
    {
        if (empty($this->_active)) {
            $this->_active = Active::get($this->active);
        }

        return $this->_active;
    }
}
