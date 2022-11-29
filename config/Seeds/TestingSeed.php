<?php

declare(strict_types=1);

use App\Model\Entity\AppUser;
use App\Model\Field\UserRole;
use Cake\ORM\Locator\LocatorAwareTrait;
use Migrations\AbstractSeed;
use Faker\Factory;

/**
 * Testing seed.
 */
class TestingSeed extends AbstractSeed
{
    use LocatorAwareTrait;

    private const STUDENTS_QTY = 30;

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
    public function run()
    {
        $this->AppUsers = $this->fetchTable('AppUsers');

        $this->faker = Factory::create('es_VE');
        $this->createAdmins();
        $this->createStudents();
    }

    protected function createAdmins()
    {
        $users[] = $this->setupUser([
            'email' => 'admin@example.com',
            'password' => '1234',
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
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

    protected function createStudents()
    {
        $users = [];
        for ($i = 0; $i < self::STUDENTS_QTY; $i++) {
            $users[] = $this->setupUser([
                'email' => $this->faker->safeEmail(),
                'password' => '1234',
                'first_name' => $this->faker->firstName(),
                'last_name' => $this->faker->lastName(),
                'role' => UserRole::STUDENT->value,
                'active' => true,
                'tenant_filters' => [
                    ['tenant_id' => 1],
                ],
            ]);
        }

        $this->AppUsers->saveManyOrFail($users);

        foreach ($users as $user) {
            $this->AppUsers->Students->newRegularStudent($user);
        }
    }

    protected function setupUser(array $data): AppUser
    {
        $user = $this->AppUsers->newEntity($data);
        $user->set('role', $data['role']);

        return $user;
    }
}
