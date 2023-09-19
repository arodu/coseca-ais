<?php

declare(strict_types=1);

namespace App\Utility;

use Cake\Core\Configure;

class Calc
{
    /**
     * @param integer|float $completed
     * @param integer|float|null $total
     * @param integer $decimals
     * @return float
     */
    public static function percentHoursCompleted(int|float $completed, int|float $total = null, int $decimals = 1): float
    {
        $total = $total ?? self::getTotalHours();

        if ($completed >= $total) {
            return 100;
        }

        $result = ($completed * 100) / $total;

        return round($result, $decimals);
    }

    public static function getTotalHours(): float
    {
        return (float) Configure::read('coseca.hours-min');
    }
}
