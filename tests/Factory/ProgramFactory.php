<?php

declare(strict_types=1);

namespace App\Test\Factory;

use App\Model\Field\ProgramRegime;
use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * ProgramFactory
 *
 * @method \App\Model\Entity\Program getEntity()
 * @method \App\Model\Entity\Program[] getEntities()
 * @method \App\Model\Entity\Program|\App\Model\Entity\Program[] persist()
 * @method static \App\Model\Entity\Program get(mixed $primaryKey, array $options = [])
 */
class ProgramFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'Programs';
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
                'name' => 'Informática',
                'area' => 'ais',
                'regime' => ProgramRegime::BIANNUAL->value,
                'abbr' => 'INF',
            ];
        });
    }

    public function withTenants(): self
    {
        return $this->with('Tenants', [
            [
                'name' => 'San Juan',
                'abbr' => 'SJM',
            ],
            [
                'name' => 'Mellado',
                'abbr' => 'MEL',
            ],
            [
                'name' => 'Ortiz',
                'abbr' => 'ORT',
            ],
        ]);
    }
    
    public function base(): self
    {
        return $this
            ->withTenants();

    }



}
