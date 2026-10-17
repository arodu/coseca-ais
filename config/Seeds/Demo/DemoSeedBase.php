<?php

declare(strict_types=1);

use Cake\ORM\Locator\LocatorAwareTrait;
use Migrations\AbstractSeed;

/**
 * Base para los sub-seeds del demo (`config/Seeds/Demo/`).
 *
 * No son descubiertos por Phinx (glob no recursivo) ni autocargables; el
 * orquestador `DemoSeed` los carga con `require_once` y les inyecta el `Rng`
 * (para determinismo) y el adapter (para `$this->table()`/`$this->execute()`).
 */
abstract class DemoSeedBase extends AbstractSeed
{
    use LocatorAwareTrait;

    protected Rng $rng;

    private ?array $profile = null;

    /**
     * Inyecta el RNG compartido (ya sembrado) por el orquestador.
     *
     * @param \Rng $rng Generador.
     * @return void
     */
    public function setRng(Rng $rng): void
    {
        $this->rng = $rng;
    }

    /**
     * Huella congelada + targets del demo.
     *
     * @return array
     */
    protected function profile(): array
    {
        return $this->profile ??= require __DIR__ . '/data/profile.php';
    }

    /**
     * Carga un dataset de léxico de `data/`.
     *
     * @param string $name Nombre sin extensión.
     * @return array
     */
    protected function data(string $name): array
    {
        return require __DIR__ . '/data/' . $name . '.php';
    }

    /**
     * Elige un elemento de una lista de pesos `[valor => peso]`.
     *
     * @param array $weights Mapa valor => peso.
     * @return mixed
     */
    protected function weighted(array $weights): mixed
    {
        $total = array_sum($weights);
        $roll = $this->rng->float(0, (float)$total);
        $acc = 0.0;
        foreach ($weights as $value => $weight) {
            $acc += $weight;
            if ($roll <= $acc) {
                return $value;
            }
        }

        return array_key_first($weights);
    }

    /**
     * Nombre de pila verosímil.
     *
     * @return string
     */
    protected function firstName(): string
    {
        $people = $this->data('people');

        return $this->rng->pick($this->rng->chance(60) ? $people['first_names_m'] : $people['first_names_f']);
    }

    /**
     * Apellido verosímil.
     *
     * @return string
     */
    protected function lastName(): string
    {
        return $this->rng->pick($this->data('people')['last_names']);
    }
}
