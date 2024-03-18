<?php
declare(strict_types=1);

namespace App\Test\Factory;

use App\Model\Field\ProgramArea;
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
            $program = $faker->randomElement([
                ['name' => 'Informática', 'regime' => ProgramRegime::BIANNUAL->value, 'abbr' => 'INF'],
                ['name' => 'Medicina', 'regime' => ProgramRegime::ANNUALIZED_6->value, 'abbr' => 'MED'],
                ['name' => 'Contaduría', 'regime' => ProgramRegime::ANNUALIZED_5->value, 'abbr' => 'CON'],
            ]);

            return [
                'name' => $program['name'],
                'regime' => $program['regime'],
                'abbr' => $program['abbr'],
            ];
        });
    }
}
