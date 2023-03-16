<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class DataVenezuela extends AbstractMigration
{
    public function up()
    {
        $this->execute(file_get_contents(CONFIG . 'Migrations/raw/venezuela.sql'));
    }

    public function down()
    {
        $this->table('sys_parishes')->truncate();
        $this->table('sys_municipalities')->truncate();
        $this->table('sys_cities')->truncate();
        $this->table('sys_states')->truncate();
    }
}
