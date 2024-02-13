<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Field\UserRole;
use CakeDC\Users\Model\Entity\User;

/**
 * User Entity
 *
 * @property string $id
 * @property string $username
 * @property string|null $email
 * @property string $password
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $token
 * @property \Cake\I18n\DateTime|null $token_expires
 * @property string|null $api_token
 * @property \Cake\I18n\DateTime|null $activation_date
 * @property string|null $secret
 * @property bool|null $secret_verified
 * @property \Cake\I18n\DateTime|null $tos_date
 * @property bool $active
 * @property bool $is_superuser
 * @property string|null $role
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 * @property string|null $additional_data
 * @property \Cake\I18n\DateTime|null $last_login
 *
 * @property \App\Model\Entity\SocialAccount[] $social_accounts
 * @property \App\Model\Entity\Student[] $students
 */
class AppUser extends User
{
    /**
     * @return \App\Model\Field\UserRole|null
     */
    public function getRole(): ?UserRole
    {
        return UserRole::tryFrom($this->role);
    }

    /**
     * @var array
     */
    protected array $_virtual = ['full_name'];

    /**
     * @return string
     */
    protected function _getFullName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
