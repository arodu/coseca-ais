<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\TrashComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\TrashComponent Test Case
 */
class TrashComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\TrashComponent
     */
    protected $Trash;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Trash = new TrashComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Trash);

        parent::tearDown();
    }
}
