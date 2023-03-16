<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SysStatesFixture
 */
class SysStatesFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'state_id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'iso' => 'Lo',
            ],
        ];
        parent::init();
    }
}
