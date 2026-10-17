<?php

declare(strict_types=1);

/**
 * Generador pseudoaleatorio determinista del demo, sin dependencias externas.
 *
 * Usa el Mersenne Twister de PHP sembrado con `mt_srand()`; cada corrida con la
 * misma semilla produce la misma secuencia. Reemplaza a `fakerphp/faker` en los
 * seeds (todos los métodos usan `mt_rand`, incluido el barajado manual).
 */
class Rng
{
    /**
     * @param int|null $seed Semilla; si es null, usa el estado por defecto de PHP.
     */
    public function __construct(?int $seed = null)
    {
        if ($seed !== null) {
            mt_srand($seed);
        }
    }

    /**
     * Entero en el rango [$min, $max].
     *
     * @param int $min Mínimo.
     * @param int $max Máximo.
     * @return int
     */
    public function intBetween(int $min, int $max): int
    {
        return mt_rand($min, $max);
    }

    /**
     * Elemento aleatorio de una lista no vacía.
     *
     * @param array $items Lista.
     * @return mixed
     */
    public function pick(array $items): mixed
    {
        return $items[mt_rand(0, count($items) - 1)];
    }

    /**
     * Float en el rango [$min, $max].
     *
     * @param float $min Mínimo.
     * @param float $max Máximo.
     * @return float
     */
    public function float(float $min = 0.0, float $max = 1.0): float
    {
        return $min + ($max - $min) * (mt_rand() / mt_getrandmax());
    }

    /**
     * Verdadero con probabilidad `$percent`%.
     *
     * @param int $percent Porcentaje (0-100).
     * @return bool
     */
    public function chance(int $percent): bool
    {
        return mt_rand(1, 100) <= $percent;
    }

    /**
     * Copia mezclada del arreglo (Fisher-Yates con `mt_rand`, determinista).
     *
     * @param array $items Lista.
     * @return array
     */
    public function shuffle(array $items): array
    {
        $items = array_values($items);
        for ($i = count($items) - 1; $i > 0; $i--) {
            $j = mt_rand(0, $i);
            [$items[$i], $items[$j]] = [$items[$j], $items[$i]];
        }

        return $items;
    }

    /**
     * Cadena de dígitos de longitud `$length`.
     *
     * @param int $length Longitud.
     * @return string
     */
    public function digits(int $length): string
    {
        $out = '';
        for ($i = 0; $i < $length; $i++) {
            $out .= (string)mt_rand(0, 9);
        }

        return $out;
    }

    /**
     * UUID v4 determinista.
     *
     * @return string
     */
    public function uuid(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
        );
    }
}
