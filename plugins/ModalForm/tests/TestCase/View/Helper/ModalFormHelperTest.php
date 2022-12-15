<?php
declare(strict_types=1);

namespace ModalForm\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use ModalForm\View\Helper\ModalFormHelper;

/**
 * ModalForm\View\Helper\ModalFormHelper Test Case
 */
class ModalFormHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \ModalForm\View\Helper\ModalFormHelper
     */
    protected $ModalForm;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $view = new View();
        $this->ModalForm = new ModalFormHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ModalForm);

        parent::tearDown();
    }
}
