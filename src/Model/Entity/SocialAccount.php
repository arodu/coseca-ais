<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SocialAccount Entity
 *
 * @property string $id
 * @property string $user_id
 * @property string $provider
 * @property string|null $username
 * @property string $reference
 * @property string|null $avatar
 * @property string|null $description
 * @property string $link
 * @property string $token
 * @property string|null $token_secret
 * @property \Cake\I18n\DateTime|null $token_expires
 * @property bool $active
 * @property string $data
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\User $user
 */
class SocialAccount extends Entity
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
        'user_id' => true,
        'provider' => true,
        'username' => true,
        'reference' => true,
        'avatar' => true,
        'description' => true,
        'link' => true,
        'token' => true,
        'token_secret' => true,
        'token_expires' => true,
        'active' => true,
        'data' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected array $_hidden = [
        'token',
    ];
}
