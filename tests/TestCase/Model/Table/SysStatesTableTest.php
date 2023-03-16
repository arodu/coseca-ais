<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SysStatesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SysStatesTable Test Case
 */
class SysStatesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SysStatesTable
     */
    protected $SysStates;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.SysStates',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SysStates') ? [] : ['className' => SysStatesTable::class];
        $this->SysStates = $this->getTableLocator()->get('SysStates', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->SysStates);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SysStatesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
