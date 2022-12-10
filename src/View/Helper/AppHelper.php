<?php

declare(strict_types=1);

namespace App\View\Helper;

use App\Enum\Color;
use App\Enum\FaIcon;
use App\Model\Entity\Lapse;
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

    /**
     * @param float $percent
     * @param string|null $prefix
     * @return string
     */
    public function progressBarColor(float $percent, ?string $prefix = 'bg'): string
    {
        $color = match (true) {
            ($percent < 20) => Color::DANGER,
            ($percent >= 20 && $percent < 80) => Color::WARNING,
            ($percent >= 80 && $percent < 100) => Color::SUCCESS,
            ($percent >= 100) => Color::PRIMARY,
        };

        return $color->cssClass($prefix);
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

    public function error(string $tooltip = null): string
    {
        $options['class'] = [
            Color::DANGER->cssClass('badge'),
        ];
        $options['escape'] = false;
        $options['role'] = 'button';

        if (!empty($tooltip)) {
            $options['data-toggle'] = 'tooltip';
            $options['title'] = $tooltip;
        }

        $icon = FaIcon::ERROR->render('fa-fw mr-1');

        return $this->Html->tag('span', $icon . __('Error'), $options);
    }

    public function lapseLabel(Lapse $lapse): string
    {
        if ($lapse->active) {
            return $lapse->name;
        }

        $inactive = $this->Html->tag('span', $lapse->label_active, ['class' => $lapse->getActive()->color()->cssClass('badge')]);

        return $lapse->name . ' ' . $inactive;
    }
}
