<?php
declare(strict_types=1);

namespace App\Test\Factory;

use Cake\I18n\FrozenDate;
use Cake\ORM\Locator\LocatorAwareTrait;
use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * LapseFactory
 *
 * @method \App\Model\Entity\Lapse getEntity()
 * @method \App\Model\Entity\Lapse[] getEntities()
 * @method \App\Model\Entity\Lapse|\App\Model\Entity\Lapse[] persist()
 * @method static \App\Model\Entity\Lapse get(mixed $primaryKey, array $options = [])
 */
class LapseFactory extends CakephpBaseFactory
{
    use LocatorAwareTrait;

    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'Lapses';
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
                'name' => '2023-1',
                'active' => true,
            ];
        });
    }
}
