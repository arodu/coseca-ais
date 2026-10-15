<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * StudentTrackingFactory
 *
 * @method \App\Model\Entity\StudentTracking getEntity()
 * @method \App\Model\Entity\StudentTracking[] getEntities()
 * @method \App\Model\Entity\StudentTracking|\App\Model\Entity\StudentTracking[] persist()
 * @method static \App\Model\Entity\StudentTracking get(mixed $primaryKey, array $options = [])
 */
class StudentTrackingFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'StudentTracking';
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
                // set the model's default values
                // For example:
                // 'name' => $faker->lastName
            ];
        });
    }
}
