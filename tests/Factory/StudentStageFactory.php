<?php
declare(strict_types=1);

namespace App\Test\Factory;

use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * StudentStageFactory
 *
 * @method \App\Model\Entity\StudentStage getEntity()
 * @method \App\Model\Entity\StudentStage[] getEntities()
 * @method \App\Model\Entity\StudentStage|\App\Model\Entity\StudentStage[] persist()
 * @method static \App\Model\Entity\StudentStage get(mixed $primaryKey, array $options = [])
 */
class StudentStageFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'StudentStages';
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
                'stage' => StageField::REGISTER->value,
                'status' => StageStatus::WAITING->value,
            ];
        });
    }

    public function whitStage(StageField $stageField): self
    {
        return $this->patchData('stage', $stageField->value);
    }
}
