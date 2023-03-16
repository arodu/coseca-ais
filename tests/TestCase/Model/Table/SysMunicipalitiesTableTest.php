<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SysMunicipalitiesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SysMunicipalitiesTable Test Case
 */
class SysMunicipalitiesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SysMunicipalitiesTable
     */
    protected $SysMunicipalities;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.SysMunicipalities',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SysMunicipalities') ? [] : ['className' => SysMunicipalitiesTable::class];
        $this->SysMunicipalities = $this->getTableLocator()->get('SysMunicipalities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->SysMunicipalities);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SysMunicipalitiesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
