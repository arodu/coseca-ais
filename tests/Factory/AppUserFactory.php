<?php
declare(strict_types=1);

namespace App\Test\Factory;

use App\Model\Field\UserRole;
use Cake\I18n\FrozenDate;
use Cake\Utility\Hash;
use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * AppUserFactory
 *
 * @method \App\Model\Entity\AppUser getEntity()
 * @method \App\Model\Entity\AppUser[] getEntities()
 * @method \App\Model\Entity\AppUser|\App\Model\Entity\AppUser[] persist()
 * @method static \App\Model\Entity\AppUser get(mixed $primaryKey, array $options = [])
 */
class AppUserFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'AppUsers';
    }

    /**
     * Defines the factory's default values. This is useful for
     * not nullable fields. You may use methods of the present factory here too.
     *
     * @return void
     */
    protected function setDefaultTemplate(): void
    {
        $this->setDefaultData(function (Generator $faker) {
            return [
                'username' => $faker->userName,
                'email' => $faker->email,
                'dni' => $faker->randomNumber(8),
                'password' => $faker->password,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'active' => true,
                'role' => null,
                'created' => FrozenDate::now(),
                'modified' => FrozenDate::now(),
            ];
        });
    }

    public function withRole(UserRole $role)
    {
        $user = $this->patchData(['role' => $role->value]);

        if ($role->isStudentGroup()) {
            $user = $user->withStudent();
        }

        return $user;
    }

    //public function withTenants()
    //{
    //    $program = ProgramFactory::make()
    //        ->withTenants()
    //        ->persist();
    //
    //    return $this->patchData(['tenant_id' => Hash::get($program, 'tenants.0.id')]);
    //}

    public function withStudents($makeParameter = [], int $times = 1)
    {
        return $this->with('Students', StudentFactory::make($makeParameter, $times));
    }


}
