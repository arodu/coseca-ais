<?php

declare(strict_types=1);

use App\Model\Entity\AppUser;
use App\Model\Field\UserRole;

/**
 * Usuarios de staff del demo (root/manager/admin) con sus `tenant_filters`.
 *
 * Basado en la antigua semilla de desarrollo, con un cambio decidido: el admin
 * genérico ve los 4 tenants del demo (antes 1–3).
 */
class AdminSeed extends DemoSeedBase
{
    /**
     * @return void
     */
    public function run(): void
    {
        $users = [
            $this->user('root@example.com', UserRole::ROOT, []),
            $this->user('manager@example.com', UserRole::MANAGER, []),
            $this->user('admin@example.com', UserRole::ADMIN, [1, 2, 3, 4]),
            $this->user('sanjuan@example.com', UserRole::ADMIN, [1]),
            $this->user('mellado@example.com', UserRole::ADMIN, [2]),
            $this->user('ortiz@example.com', UserRole::ADMIN, [3]),
            $this->user('calabozo@example.com', UserRole::ADMIN, [4]),
        ];

        $this->fetchTable('AppUsers')->saveManyOrFail($users);
    }

    /**
     * Construye un usuario de staff.
     *
     * @param string $email Email (y username).
     * @param \App\Model\Field\UserRole $role Rol.
     * @param array<int, int> $tenants Ids de tenant para `tenant_filters`.
     * @return \App\Model\Entity\AppUser
     */
    private function user(string $email, UserRole $role, array $tenants): AppUser
    {
        $data = [
            'email' => $email,
            'password' => '1234',
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'role' => $role->value,
            'active' => true,
        ];

        if ($tenants !== []) {
            $data['tenant_filters'] = array_map(
                fn (int $id): array => ['tenant_id' => $id],
                $tenants,
            );
        }

        $user = $this->fetchTable('AppUsers')->newEntity($data);
        $user->set('role', $role->value);

        return $user;
    }
}
