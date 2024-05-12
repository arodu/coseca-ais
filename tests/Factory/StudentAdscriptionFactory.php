<?php

declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * StudentAdscriptionFactory
 *
 * @method \App\Model\Entity\StudentAdscription getEntity()
 * @method \App\Model\Entity\StudentAdscription[] getEntities()
 * @method \App\Model\Entity\StudentAdscription|\App\Model\Entity\StudentAdscription[] persist()
 * @method static \App\Model\Entity\StudentAdscription get(mixed $primaryKey, array $options = [])
 */
class StudentAdscriptionFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'StudentAdscriptions';
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
                'principal' => true,
            ];
        });
    }
}
