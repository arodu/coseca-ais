<?php

declare(strict_types=1);

use Cake\ORM\Locator\LocatorAwareTrait;
use Migrations\AbstractMigration;

class FixAreasData extends AbstractMigration
{
    use LocatorAwareTrait;

    /**
     * @var array
     */
    protected $areas = [
        'ais' => ['name' => 'Área de Ingeniería de Sistemas', 'abbr' => 'AIS'],
    ];

    public function up(): void
    {
        $areasTable = $this->fetchTable('Areas');
        $programsTable = $this->fetchTable('Programs');

        foreach ($this->areas as $key => $areaData) {
            $area = $areasTable->newEntity($areaData);
            $area->created = date('Y-m-d H:i:s');
            $area->modified = date('Y-m-d H:i:s');

            $area = $areasTable->saveOrFail($area);
            $programsTable->updateAll(['area_id' => $area->id], ['area' => $key]);
        }

        $table = $this->table('programs');
        $table->removeColumn('area');
        $table->update();
    }


    public function down(): void
    {
        $areasTable = $this->fetchTable('Areas');
        $programsTable = $this->fetchTable('Programs');

        $table = $this->table('programs');
        $table->addColumn('area', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->update();

        foreach ($this->areas as $key => $areaData) {
            $area = $areasTable->find()->where(['abbr' => $areaData['abbr']])->first();
            $programsTable->updateAll(['area' => $key], ['area_id' => $area->id]);
            $areasTable->deleteOrFail($area);
        }
    }
}
