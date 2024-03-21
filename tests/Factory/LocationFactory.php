<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * LocationFactory
 *
 * @method \App\Model\Entity\Location getEntity()
 * @method \App\Model\Entity\Location[] getEntities()
 * @method \App\Model\Entity\Location|\App\Model\Entity\Location[] persist()
 * @method static \App\Model\Entity\Location get(mixed $primaryKey, array $options = [])
 */
class LocationFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'Locations';
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
            $location = $faker->randomElement([
                ['name' => 'San Juan', 'abbr' => 'SJM'],
                ['name' => 'Mellado', 'abbr' => 'MED'],
                ['name' => 'Ortiz', 'abbr' => 'ORT'],
                ['name' => 'Calabozo', 'abbr' => 'CAL'],
            ]);

            return $location;
        });
    }
}
