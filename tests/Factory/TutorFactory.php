<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * TutorFactory
 *
 * @method \App\Model\Entity\Tutor getEntity()
 * @method \App\Model\Entity\Tutor[] getEntities()
 * @method \App\Model\Entity\Tutor|\App\Model\Entity\Tutor[] persist()
 * @method static \App\Model\Entity\Tutor get(mixed $primaryKey, array $options = [])
 */
class TutorFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'Tutors';
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
                'name' => $faker->name,
                'dni' => $faker->randomNumber(8),
                'phone' => $faker->phoneNumber,
                'email' => $faker->email,
            ];
        });
    }
}
