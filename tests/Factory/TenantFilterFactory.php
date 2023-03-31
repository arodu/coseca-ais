<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * TenantFilterFactory
 *
 * @method \App\Model\Entity\TenantFilter getEntity()
 * @method \App\Model\Entity\TenantFilter[] getEntities()
 * @method \App\Model\Entity\TenantFilter|\App\Model\Entity\TenantFilter[] persist()
 * @method static \App\Model\Entity\TenantFilter get(mixed $primaryKey, array $options = [])
 */
class TenantFilterFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'TenantFilters';
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
