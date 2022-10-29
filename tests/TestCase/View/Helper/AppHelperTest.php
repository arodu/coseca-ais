<?php
declare(strict_types=1);

namespace App\Test\TestCase\View\Helper;

use App\View\Helper\AppHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\AppHelper Test Case
 */
class AppHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\View\Helper\AppHelper
     */
    protected $App;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $view = new View();
        $this->App = new AppHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->App);

        parent::tearDown();
    }
}
