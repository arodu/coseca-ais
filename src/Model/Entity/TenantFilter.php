<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TenantFilter Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $tenant_id
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\AppUser $user
 * @property \App\Model\Entity\Tenant $tenant
 */
class TenantFilter extends Entity
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
        'user_id' => true,
        'tenant_id' => true,
        'created' => true,
        'user' => true,
        'tenant' => true,
    ];
}
