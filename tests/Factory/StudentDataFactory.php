<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * StudentDataFactory
 *
 * @method \App\Model\Entity\StudentData getEntity()
 * @method \App\Model\Entity\StudentData[] getEntities()
 * @method \App\Model\Entity\StudentData|\App\Model\Entity\StudentData[] persist()
 * @method static \App\Model\Entity\StudentData get(mixed $primaryKey, array $options = [])
 */
class StudentDataFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'StudentData';
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
                'gender' => $faker->randomElement(['M', 'F']),
                'phone' => $faker->phoneNumber(),
                'address' => $faker->address(),
                'current_semester' => $faker->numberBetween(6, 10),
                'uc' => $faker->numberBetween(90, 200),
                'total_hours' => null,
            ];
        });
    }
}
