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
            $this->user('root@example.com', 'Usuario', 'Root', UserRole::ROOT, []),
            $this->user('manager@example.com', 'Usuario', 'Manager', UserRole::MANAGER, []),
            $this->user('admin@example.com', 'Usuario', 'Admin', UserRole::MANAGER, [1, 2, 3, 4]),
            $this->user('sanjuan@example.com', 'Demo', 'San Juan', UserRole::ADMIN, [1]),
            $this->user('mellado@example.com', 'Demo', 'Mellado', UserRole::ADMIN, [2]),
            $this->user('ortiz@example.com', 'Demo', 'Ortíz', UserRole::ADMIN, [3]),
            $this->user('calabozo@example.com', 'Demo', 'Calabozo', UserRole::ADMIN, [4]),
        ];

        $this->fetchTable('AppUsers')->saveManyOrFail($users);
    }

    /**
     * Construye un usuario de staff.
     *
     * @param string $email Email (y username).
     * @param string $firstName Nombre visible.
     * @param string $lastName Apellido visible.
     * @param \App\Model\Field\UserRole $role Rol.
     * @param array<int, int> $tenants Ids de tenant para `tenant_filters`.
     * @return \App\Model\Entity\AppUser
     */
    private function user(string $email, string $firstName, string $lastName, UserRole $role, array $tenants): AppUser
    {
        $data = [
            'email' => $email,
            'password' => '1234',
            'first_name' => $firstName,
            'last_name' => $lastName,
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
