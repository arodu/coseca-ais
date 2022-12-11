<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tutor Entity
 *
 * @property int $id
 * @property string $name
 * @property string $dni
 * @property string $phone
 * @property string $email
 * @property int $tenant_id
 *
 * @property \App\Model\Entity\Tenant $tenant
 * @property \App\Model\Entity\Adscription[] $adscriptions
 */
class Tutor extends Entity
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
        'dni' => true,
        'phone' => true,
        'email' => true,
        'tenant_id' => true,
        'tenant' => true,
        'adscriptions' => true,
    ];
}
