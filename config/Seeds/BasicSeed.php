<?php

declare(strict_types=1);

use App\Model\Entity\AppUser;
use App\Model\Field\UserRole;
use Cake\ORM\Locator\LocatorAwareTrait;
use Migrations\AbstractSeed;

/**
 * Basic seed: catálogos base + un admin.
 */
class BasicSeed extends AbstractSeed
{
    use LocatorAwareTrait;

    private const STUDENTS_QTY = 60;
    private const INSTITUTIONS_QTY = 10;
    private const TUTORS_QTY = 10;

    private $AppUsers;
    private $Institutions;
    private $Tutors;

    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html 
     *
     * @return void
     */
    public function run(): void
    {
        $this->runCall('InitialDataSeed');

        $this->AppUsers = $this->fetchTable('AppUsers');

        $this->createAdmins();
    }

    protected function createAdmins()
    {
        $users[] = $this->setupUser([
            'email' => 'admin@example.com',
            'password' => '1234',
            'first_name' => 'Admin',
            'last_name' => 'Demo',
            'role' => UserRole::ADMIN->value,
            'active' => true,
            'tenant_filters' => [
                ['tenant_id' => 1],
                ['tenant_id' => 2],
                ['tenant_id' => 3],
                ['tenant_id' => 4],
            ],
        ]);

        return $this->AppUsers->saveManyOrFail($users);
    }

    protected function setupUser(array $data): AppUser
    {
        $user = $this->AppUsers->newEntity($data);
        $user->set('role', $data['role']);

        return $user;
    }
}
