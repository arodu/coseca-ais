<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * AreaFactory
 *
 * @method \App\Model\Entity\Area getEntity()
 * @method \App\Model\Entity\Area[] getEntities()
 * @method \App\Model\Entity\Area|\App\Model\Entity\Area[] persist()
 * @method static \App\Model\Entity\Area get(mixed $primaryKey, array $options = [])
 */
class AreaFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'Areas';
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
                'name' => $faker->company(),
                'abbr' => $faker->randomLetter(),
                'print_label' => $faker->company(),
            ];
        });
    }
}
