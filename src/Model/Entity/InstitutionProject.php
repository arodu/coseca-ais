<?php

declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Field\AdscriptionStatus;
use Cake\ORM\Entity;

/**
 * InstitutionProject Entity
 *
 * @property int $id
 * @property int $institution_id
 * @property string $name
 * @property bool $active
 *
 * @property \App\Model\Entity\Institution $institution
 * @property \App\Model\Entity\StudentAdscription[] $student_adscriptions
 */
class InstitutionProject extends Entity
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
        'institution_id' => true,
        'name' => true,
        'active' => true,
        'institution' => true,
        'student_adscriptions' => true,
        'interest_area_id' => true,
    ];

    protected $_virtual = [
        'label_name',
    ];

    protected function _getLabelName()
    {
        if (empty($this->institution)) {
            trigger_error("entity doesn't have institution", E_USER_WARNING);

            return null;
        }

        return __('{0}: {1}', $this->institution->name, $this->name);
    }
}
