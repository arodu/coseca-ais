<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * StudentCourseFactory
 *
 * @method \App\Model\Entity\StudentCourse getEntity()
 * @method \App\Model\Entity\StudentCourse[] getEntities()
 * @method \App\Model\Entity\StudentCourse|\App\Model\Entity\StudentCourse[] persist()
 * @method static \App\Model\Entity\StudentCourse get(mixed $primaryKey, array $options = [])
 */
class StudentCourseFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'StudentCourses';
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
