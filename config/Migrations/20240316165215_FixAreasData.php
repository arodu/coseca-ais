<?php

declare(strict_types=1);

use Cake\ORM\Locator\LocatorAwareTrait;
use Migrations\AbstractMigration;
use Cake\I18n\FrozenTime;

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

        $areaKeys = $programsTable
            ->find('list', ['valueField' => 'area'])
            ->distinct()
            ->toArray();

        foreach ($areaKeys as $key) {
            $area = $areasTable->newEntity($this->getAreaData($key));
            $area->created = FrozenTime::now();
            $area->modified = FrozenTime::now();
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
        if (!$table->hasColumn('area')) {
            $table->addColumn('area', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ]);
            $table->update();
        }

        $areas = $areasTable->find()->toArray();
        foreach ($areas as $area) {
            $programsTable->updateAll(['area' => strtolower($area->abbr)], ['area_id' => $area->id]);
            $areasTable->deleteOrFail($area);
        }
    }

    protected function getAreaData(string $key): array
    {
        return $this->areas[$key] ?? [
            'name' => $key,
            'abbr' => strtoupper($key),
            'logo' => null,
        ];
    }

}
