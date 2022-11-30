<?php

declare(strict_types=1);

namespace App\View\Helper;

use Cake\I18n\FrozenDate;
use Cake\View\Helper;

/**
 * App helper
 */
class AppHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [];

    public $helpers = ['Html'];

    public function addPrefix(string $text, ?string $prefix, string $separator = '-'): string
    {
        if (empty($prefix)) {
            return $text;
        }

        return $prefix . $separator . $text;
    }

    /**
     * @param float $percent
     * @param string|null $prefix
     * @return string
     */
    public function progressBarColor(float $percent, ?string $prefix = 'bg'): string
    {
        $color = match (true) {
            ($percent < 20) => 'danger',
            ($percent >= 20 && $percent < 80) => 'warning',
            ($percent >= 80 && $percent < 100) => 'green',
            ($percent >= 100) => 'primary',
        };

        return $this->addPrefix($color, $prefix);
    }

    /**
     * @param integer $completed
     * @param integer $total
     * @param integer $decimals
     * @return float
     */
    public function progressBarCalc(int $completed, int $total, int $decimals = 0): float
    {
        if ($completed >= $total) {
            return 100;
        }
        $result = ($completed * 100) / $total;

        return round($result, $decimals);
    }

    /**
     * @param integer $completed
     * @param integer $total
     * @return string
     */
    public function progressBar(int $completed, int $total): string
    {
        $percent = $this->progressBarCalc($completed, $total, 0);

        $output = '<div class="progress progress-sm">'
            . '<div class="progress-bar ' . $this->progressBarColor($percent) . '" role="progressbar" aria-valuenow="' . $percent . '" aria-valuemin="0" aria-valuemax="100" style="width:' . $percent . '%">'
            . '</div>'
            . '</div>'
            . '<small>' . __('{0}% Completado', $percent) . '</small>';

        return $output;
    }
}
