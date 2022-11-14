<?php
declare(strict_types=1);

namespace App\View\Helper;

use App\Enum\FaIcon;
use App\Model\Field\Stages;
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
     * @param string|null $status
     * @param boolean $complete
     * @param string $extraClass
     * @return void
     */
    public function statusIcon(?string $status = null, bool $complete = false, string $extraClass = '')
    {
        switch ($status) {
            case Stages::STATUS_IN_PROGRESS: 
                $icon = FaIcon::IN_PROGRESS;
                break;
            case Stages::STATUS_WAITING: 
                $icon = FaIcon::WAITING;
                break;
            case Stages::STATUS_SUCCESS: 
                $icon = FaIcon::SUCCESS;
                break;
            case Stages::STATUS_PENDING:
            default:
                $icon = FaIcon::PENDING;
                break;
        }

        if (!$complete) {
            return $icon->value;
        }

        return $this->faIcon($icon, $extraClass);
    }

    /**
     * @param string|null $status
     * @param string|null $prefix
     * @return void
     */
    public function statusColor(?string $status = null, ?string $prefix = 'card')
    {
        switch ($status) {
            case Stages::STATUS_IN_PROGRESS: 
                $color = 'warning';
                break;
            case Stages::STATUS_WAITING: 
                $color = 'info';
                break;
            case Stages::STATUS_SUCCESS: 
                $color = 'success';
                break;
            case Stages::STATUS_FAILED:
                $color = 'danger';
                break;
            case Stages::STATUS_PENDING:
            default:
                $color = 'gray';
                break;
        }

        return $this->addPrefix($color, $prefix);
    }

    /**
     * @param string|null $status
     * @param string $active
     * @param string $inactive
     * @return void
     */
    public function statusActive(?string $status = null, string $active = 'show', string $inactive = '')
    {
        switch($status) {
            case Stages::STATUS_IN_PROGRESS:
            case Stages::STATUS_WAITING:
                return $active;
                break;

            default:
                return $inactive;
                break;
        }
    }

    /**
     * @param string $text
     * @param string|null $prefix
     * @param string $separator
     * @return string
     */
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

    /**
     * @param FaIcon $icon
     * @param string|null $extraClass
     * @return string
     */
    public function faIcon(FaIcon $icon, ?string $extraClass = null): string
    {
        return $this->Html->tag('i', '', [
            'class' => [$icon->value, $extraClass],
        ]);
    }

}
