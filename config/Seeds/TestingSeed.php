<?php

declare(strict_types=1);

use App\Model\Entity\AppUser;
use App\Model\Field\UserRole;
use Cake\ORM\Locator\LocatorAwareTrait;
use Migrations\AbstractSeed;
use Faker\Factory;

/**
 * @property \Faker\Generator $faker
 * 
 * Testing seed.
 */
class TestingSeed extends AbstractSeed
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
        $this->Institutions = $this->fetchTable('Institutions');
        $this->Tutors = $this->fetchTable('Tutors');

        //$this->faker = Factory::create('es_VE');
        $this->faker = Factory::create();
        $this->createAdmins();
        $this->createStudents();
        $this->createInstitutions();
        $this->createTutors();
    }

    protected function createAdmins()
    {
        $users[] = $this->setupUser([
            'email' => 'root@example.com',
            'password' => '1234',
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'role' => UserRole::ROOT->value,
            'active' => true,
        ]);

        $users[] = $this->setupUser([
            'email' => 'manager@example.com',
            'password' => '1234',
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'role' => UserRole::MANAGER->value,
            'active' => true,
        ]);

        $users[] = $this->setupUser([
            'email' => 'admin@example.com',
            'password' => '1234',
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'role' => UserRole::ADMIN->value,
            'active' => true,
            'tenant_filters' => [
                ['tenant_id' => 1], // San Juan
                ['tenant_id' => 2], // Mellado
                ['tenant_id' => 3], // Ortíz
            ],
        ]);

        $users[] = $this->setupUser([
            'email' => 'sanjuan@example.com',
            'password' => '1234',
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'role' => UserRole::ADMIN->value,
            'active' => true,
            'tenant_filters' => [
                ['tenant_id' => 1], // San Juan
            ],
        ]);

        $users[] = $this->setupUser([
            'email' => 'mellado@example.com',
            'password' => '1234',
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'role' => UserRole::ADMIN->value,
            'active' => true,
            'tenant_filters' => [
                ['tenant_id' => 2], // Mellado
            ],
        ]);

        $users[] = $this->setupUser([
            'email' => 'ortiz@example.com',
            'password' => '1234',
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'role' => UserRole::ADMIN->value,
            'active' => true,
            'tenant_filters' => [
                ['tenant_id' => 3], // Ortíz
            ],
        ]);

        $users[] = $this->setupUser([
            'email' => 'calabozo@example.com',
            'password' => '1234',
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'role' => UserRole::ADMIN->value,
            'active' => true,
            'tenant_filters' => [
                ['tenant_id' => 4], // Calabozo
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
                'dni' => $this->faker->numberBetween(20000000, 29000000),
                'first_name' => $this->faker->firstName(),
                'last_name' => $this->faker->lastName(),
                'role' => UserRole::STUDENT->value,
                'active' => true,
                'tenant_filters' => [
                    ['tenant_id' => rand(1, 4)],
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

    protected function createInstitutions()
    {
        $institutions = [];
        for ($i = 0; $i < self::INSTITUTIONS_QTY; $i++) {
            $institution_projects = [];
            for ($p = 0; $p < rand(1, 4); $p++) {
                $institution_projects[] = [
                    'name' => $this->faker->sentence(3),
                    'active' => true,
                ];
            }

            $institutions[] = $this->Institutions->newEntity([
                'name' => $this->faker->company(),
                'active' => true,
                'contact_person' => $this->faker->name(),
                'contact_phone' => $this->faker->phoneNumber(),
                'contact_email' => $this->faker->companyEmail(),
                'tenant_id' => rand(1, 4),
                'institution_projects' => $institution_projects,
            ]);
        }

        return $this->Institutions->saveManyOrFail($institutions);
    }

    protected function createTutors()
    {
        $tutors = [];
        for ($i = 0; $i < self::TUTORS_QTY; $i++) {
            $tutors[] = $this->Tutors->newEntity([
                'name' => $this->faker->name(),
                'dni' => $this->faker->numberBetween(10000000, 17000000),
                'phone' => $this->faker->phoneNumber(),
                'email' => $this->faker->email(),
                'tenant_id' => rand(1, 4),
            ]);
        }

        return $this->Tutors->saveManyOrFail($tutors);
    }
}
