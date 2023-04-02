<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * InterestAreaFactory
 *
 * @method \App\Model\Entity\InterestArea getEntity()
 * @method \App\Model\Entity\InterestArea[] getEntities()
 * @method \App\Model\Entity\InterestArea|\App\Model\Entity\InterestArea[] persist()
 * @method static \App\Model\Entity\InterestArea get(mixed $primaryKey, array $options = [])
 */
class InterestAreaFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'InterestAreas';
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
                'name' => $faker->word(),
                'description' => $faker->sentence(),
                'active' => true,
            ];
        });
    }
}
