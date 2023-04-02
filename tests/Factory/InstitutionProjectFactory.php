<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * InstitutionProjectFactory
 *
 * @method \App\Model\Entity\InstitutionProject getEntity()
 * @method \App\Model\Entity\InstitutionProject[] getEntities()
 * @method \App\Model\Entity\InstitutionProject|\App\Model\Entity\InstitutionProject[] persist()
 * @method static \App\Model\Entity\InstitutionProject get(mixed $primaryKey, array $options = [])
 */
class InstitutionProjectFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'InstitutionProjects';
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
                'name' => $faker->sentence(3),
                'active' => true,
                'interest_area_id' => null,
            ];
        });
    }
}
