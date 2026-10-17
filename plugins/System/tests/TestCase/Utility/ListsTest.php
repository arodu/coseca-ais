<?php
declare(strict_types=1);

namespace System\Test\TestCase\Utility;

use Cake\Cache\Cache;
use Cake\Database\Connection;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\TestSuite\TestCase;
use System\Utility\Lists;

/**
 * System\Utility\Lists Test Case
 *
 * Covers the geography lookups (states/cities/municipalities/parishes) and the
 * typed signatures relaxed for PHP 8.4 (`?string`, `int|string|null`).
 */
class ListsTest extends TestCase
{
    use LocatorAwareTrait;

    protected Connection $connection;

    protected int $stateAId;

    protected int $stateBId;

    protected int $cityAId;

    protected int $municipalityAId;

    protected int $municipalityBId;

    protected int $parishAId;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->connection = ConnectionManager::get('test');
        $this->connection->begin();
        Cache::clearAll();

        $states = $this->getTableLocator()->get('System.States');
        $savedStates = $states->saveManyOrFail($states->newEntities([
            ['name' => 'Amazonas', 'iso' => 'VE-Z'],
            ['name' => 'Anzoátegui', 'iso' => 'VE-B'],
        ]));
        $this->stateAId = $savedStates[0]->id;
        $this->stateBId = $savedStates[1]->id;

        $cities = $this->getTableLocator()->get('System.Cities');
        $savedCities = $cities->saveManyOrFail($cities->newEntities([
            ['name' => 'Puerto Ayacucho', 'state_id' => $this->stateAId, 'capital' => true],
            ['name' => 'Barcelona', 'state_id' => $this->stateBId, 'capital' => true],
        ]));
        $this->cityAId = $savedCities[0]->id;

        $municipalities = $this->getTableLocator()->get('System.Municipalities');
        $savedMunicipalities = $municipalities->saveManyOrFail($municipalities->newEntities([
            ['name' => 'Atures', 'state_id' => $this->stateAId],
            ['name' => 'Simón Bolívar', 'state_id' => $this->stateBId],
        ]));
        $this->municipalityAId = $savedMunicipalities[0]->id;
        $this->municipalityBId = $savedMunicipalities[1]->id;

        $parishes = $this->getTableLocator()->get('System.Parishes');
        $savedParishes = $parishes->saveManyOrFail($parishes->newEntities([
            ['name' => 'Fernando Girón Tovar', 'municipality_id' => $this->municipalityAId],
            ['name' => 'El Carmen', 'municipality_id' => $this->municipalityBId],
        ]));
        $this->parishAId = $savedParishes[0]->id;
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        $this->connection->rollback();
        Cache::clearAll();

        parent::tearDown();
    }

    /**
     * @return void
     */
    public function testStatesReturnsAllStates(): void
    {
        $result = Lists::states();

        $this->assertEqualsCanonicalizing([
            $this->stateAId => 'Amazonas',
            $this->stateBId => 'Anzoátegui',
        ], $result);
    }

    /**
     * @return void
     */
    public function testGetWithoutFieldReturnsFullList(): void
    {
        $result = Lists::get('System.Municipalities');

        $this->assertEqualsCanonicalizing([
            $this->municipalityAId => 'Atures',
            $this->municipalityBId => 'Simón Bolívar',
        ], $result);
    }

    /**
     * @return void
     */
    public function testGetWithFieldAndReferenceFilters(): void
    {
        $result = Lists::get('System.Municipalities', 'state_id', $this->stateAId);

        $this->assertSame([$this->municipalityAId => 'Atures'], $result);
    }

    /**
     * @return void
     */
    public function testCititesAcceptsIntegerStateId(): void
    {
        $result = Lists::citites($this->stateAId);

        $this->assertSame([$this->cityAId => 'Puerto Ayacucho'], $result);
    }

    /**
     * @return void
     */
    public function testCititesAcceptsStringStateId(): void
    {
        $result = Lists::citites((string)$this->stateAId);

        $this->assertSame([$this->cityAId => 'Puerto Ayacucho'], $result);
    }

    /**
     * @return void
     */
    public function testCititesWithoutReferenceReturnsAllCities(): void
    {
        $result = Lists::citites();

        $this->assertCount(2, $result);
    }

    /**
     * @return void
     */
    public function testMunicipalitiesAcceptsIntegerStateId(): void
    {
        $result = Lists::municipalities($this->stateBId);

        $this->assertSame([$this->municipalityBId => 'Simón Bolívar'], $result);
    }

    /**
     * @return void
     */
    public function testMunicipalitiesAcceptsStringStateId(): void
    {
        $result = Lists::municipalities((string)$this->stateBId);

        $this->assertSame([$this->municipalityBId => 'Simón Bolívar'], $result);
    }

    /**
     * @return void
     */
    public function testMunicipalitiesWithoutReferenceReturnsAll(): void
    {
        $result = Lists::municipalities();

        $this->assertCount(2, $result);
    }

    /**
     * @return void
     */
    public function testParishesAcceptsIntegerMunicipalityId(): void
    {
        $result = Lists::parishes($this->municipalityAId);

        $this->assertSame([$this->parishAId => 'Fernando Girón Tovar'], $result);
    }

    /**
     * @return void
     */
    public function testParishesAcceptsStringMunicipalityId(): void
    {
        $result = Lists::parishes((string)$this->municipalityAId);

        $this->assertSame([$this->parishAId => 'Fernando Girón Tovar'], $result);
    }

    /**
     * @return void
     */
    public function testParishesWithoutReferenceReturnsAll(): void
    {
        $result = Lists::parishes();

        $this->assertCount(2, $result);
    }
}
