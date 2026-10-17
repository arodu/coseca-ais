<?php

declare(strict_types=1);

use Faker\Generator;
use Migrations\AbstractSeed;

require_once __DIR__ . '/Demo/DemoSeedBase.php';
require_once __DIR__ . '/Demo/CatalogSeed.php';
require_once __DIR__ . '/Demo/AdminSeed.php';
require_once __DIR__ . '/Demo/InstitutionSeed.php';
require_once __DIR__ . '/Demo/TutorSeed.php';
require_once __DIR__ . '/Demo/StudentSeed.php';
require_once __DIR__ . '/Demo/WorkflowSeed.php';

/**
 * Semilla demo realista y determinista.
 *
 * Orquesta: catálogos base (`InitialDataSeed`) + generadores del demo. Los
 * sub-seeds viven en `Demo/` y no son descubiertos por Phinx (glob no
 * recursivo), así que se cargan con `require_once` y se ejecutan con el mismo
 * wiring que `AbstractSeed::runCall()` (inyectando adapter/input/output).
 *
 * Uso: `bin/cake migrations seed --seed DemoSeed` (o `composer reset-demo`).
 */
class DemoSeed extends AbstractSeed
{
    /**
     * Sub-seeds en orden de dependencia.
     *
     * @var array<int, class-string>
     */
    private const SEEDS = [
        'CatalogSeed',
        'AdminSeed',
        'InstitutionSeed',
        'TutorSeed',
        'StudentSeed',
        'WorkflowSeed',
    ];

    /**
     * @return void
     */
    public function run(): void
    {
        /** @var array $profile */
        $profile = require __DIR__ . '/Demo/data/profile.php';

        $faker = \Faker\Factory::create('es_VE');
        $faker->seed($profile['seed']);

        $this->call('InitialDataSeed');

        foreach (self::SEEDS as $class) {
            $this->runSubSeed($class, $faker);
        }
    }

    /**
     * Ejecuta un sub-seed de `Demo/` inyectando Faker, adapter, input y output.
     *
     * @param class-string $class Sub-seed.
     * @param \Faker\Generator $faker Generador determinista compartido.
     * @return void
     */
    private function runSubSeed(string $class, Generator $faker): void
    {
        $seed = new $class();
        $seed->setFaker($faker);
        $seed->setOutput($this->getOutput());
        $seed->setAdapter($this->getAdapter());
        if ($this->input !== null) {
            $seed->setInput($this->input);
        }

        $seed->run();
    }
}
