<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Entity\Traits\RecordStatusTrait;
use Cake\ORM\Entity;

/**
 * Institution Entity
 *
 * @property int $id
 * @property string $name
 * @property bool $active
 * @property string $contact_person
 * @property string $contact_phone
 * @property string $contact_email
 * @property int $tenant_id
 *
 * @property \App\Model\Entity\Tenant $tenant
 * @property \App\Model\Entity\InstitutionProject[] $institution_projects
 */
class Institution extends Entity
{
    use RecordStatusTrait;

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
        'contact_person' => true,
        'contact_phone' => true,
        'contact_email' => true,
        'tenant_id' => true,
        'tenant' => true,
        'institution_projects' => true,
        'state_id' => true,
        'state' => true,
        'municipality_id' => true,
        'municipality' => true,
        'parish_id' => true,
        'parish' => true,
        'created' => true,
        'created_by' => true,
        'modified' => true,
        'modified_by' => true,
        'deleted' => true,
        'deleted_by' => true,
    ];
}
