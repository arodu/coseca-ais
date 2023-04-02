<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * InstitutionFactory
 *
 * @method \App\Model\Entity\Institution getEntity()
 * @method \App\Model\Entity\Institution[] getEntities()
 * @method \App\Model\Entity\Institution|\App\Model\Entity\Institution[] persist()
 * @method static \App\Model\Entity\Institution get(mixed $primaryKey, array $options = [])
 */
class InstitutionFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'Institutions';
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
                'name' => $faker->company,
                'active' => true,
                'contact_person' => $faker->name,
                'contact_phone' => $faker->phoneNumber,
                'contact_email' => $faker->email,
                'municipality_id' => 1,
                'municipality' => 1,
                'parish_id' => 1,
            ];
        });
    }
}
