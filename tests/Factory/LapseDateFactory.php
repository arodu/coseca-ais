<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * LapseDateFactory
 *
 * @method \App\Model\Entity\LapseDate getEntity()
 * @method \App\Model\Entity\LapseDate[] getEntities()
 * @method \App\Model\Entity\LapseDate|\App\Model\Entity\LapseDate[] persist()
 * @method static \App\Model\Entity\LapseDate get(mixed $primaryKey, array $options = [])
 */
class LapseDateFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'LapseDates';
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
