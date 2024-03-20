<?php

declare(strict_types=1);

use Cake\ORM\Locator\LocatorAwareTrait;
use Migrations\AbstractMigration;
use Cake\I18n\FrozenTime;

class FixAreasData extends AbstractMigration
{
    /**
     * @var array
     */
    protected $areas = [
        'ais' => ['name' => 'Área de Ingeniería de Sistemas', 'abbr' => 'AIS'],
    ];

    public function up(): void
    {
        $areaKeys = $this->fetchAll('SELECT DISTINCT area FROM programs');

        foreach ($areaKeys ?? [] as $item) {
            $key = $item['area'];
            $data = array_merge([
                'name' => $key,
                'abbr' => strtoupper($key),
                'logo' => null,
                'created' => FrozenTime::now()->format('Y-m-d H:i:s'),
                'modified' => FrozenTime::now()->format('Y-m-d H:i:s'),
            ], $this->areas[$key] ?? []);
            $this->table('areas')->insert($data)->saveData();
            $area = $this->fetchRow('SELECT * FROM areas WHERE abbr = "' . $data['abbr'] . '"');

            $this->execute('UPDATE programs SET area_id = ? WHERE area = ?', [$area['id'], $key]);
        }

        $table = $this->table('programs');
        $table->removeColumn('area');
        $table->update();
    }

    public function down(): void
    {
        $table = $this->table('programs');
        $table->addColumn('area', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->update();

        $areas = $this->fetchAll('SELECT * FROM areas');
        foreach ($areas ?? [] as $area) {
            $this->execute('UPDATE programs SET area = ? WHERE area_id = ?', [strtolower($area['abbr']), $area['id']]);
        }
    }
}
