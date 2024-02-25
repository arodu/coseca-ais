<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * TenantFactory
 *
 * @method \App\Model\Entity\Tenant getEntity()
 * @method \App\Model\Entity\Tenant[] getEntities()
 * @method \App\Model\Entity\Tenant|\App\Model\Entity\Tenant[] persist()
 * @method static \App\Model\Entity\Tenant get(mixed $primaryKey, array $options = [])
 */
class TenantFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'Tenants';
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
            $tenant = $faker->randomElement([
                ['name' => 'San Juan', 'abbr' => 'SJM', 'active' => true],
                ['name' => 'Ortiz', 'abbr' => 'ORT', 'active' => true],
                ['name' => 'Mellado', 'abbr' => 'MEL', 'active' => true],
                ['name' => 'Calabozo', 'abbr' => 'CAL', 'active' => true],
            ]);

            return [
                'name' => $tenant['name'],
                'abbr' => $tenant['abbr'],
                'active' => $tenant['active'],
            ];
        });
    }
}
