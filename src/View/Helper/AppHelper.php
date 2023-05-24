<?php

declare(strict_types=1);

namespace App\View\Helper;

use App\Model\Entity\Lapse;
use Cake\Utility\Inflector;
use Cake\View\Helper;
use CakeLteTools\Enum\BadgeInterface;
use CakeLteTools\Enum\Color;
use CakeLteTools\Utility\FaIcon;

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

    public $helpers = ['Html', 'Form'];

    public function nan(array $options = []): string
    {
        $text = $options['text'] ?? 'N/A';
        unset($options['text']);

        $tag = $options['tag'] ?? 'code';
        unset($options['tag']);

        return $this->Html->tag($tag, $text, $options);
    }

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
     * @param float $completed
     * @param float $total
     * @param integer $decimals
     * @return float
     */
    public function progressBarCalc(float $completed, float $total, int $decimals = 0): float
    {
        if ($completed >= $total) {
            return 100;
        }
        $result = ($completed * 100) / $total;

        return round($result, $decimals);
    }

    /**
     * @param float $completed
     * @param float $total
     * @return string
     */
    public function progressBar(float $completed, float $total): string
    {
        $percent = $this->progressBarCalc($completed, $total, 1);

        $progressBar = $this->Html->tag('div', '', [
            'class' => 'progress-bar ' . $this->progressBarColor($percent),
            'role' => 'progressbar',
            'aria-valuenow' => $percent,
            'aria-valuemin' => 0,
            'aria-valuemax' => 100,
            'style' => 'width:' . $percent . '%',
        ]);

        $contain = $this->Html->tag('div', $progressBar, [
            'class' => 'progress progress-sm',
            'title' => __('{0} horas', $completed),
        ]);

        $text = $this->Html->tag('small', __('{0}% Completado', $percent));

        return $contain . $text;
    }

    public function error(string $tooltip = null): string
    {
        $options['class'] = [
            Color::DANGER->badge(),
        ];
        $options['escape'] = false;
        $options['role'] = 'button';

        if (!empty($tooltip)) {
            $options['data-toggle'] = 'tooltip';
            $options['title'] = $tooltip;
        }

        $icon = FaIcon::get('error', 'fa-fw mr-1');

        return $this->Html->tag('span', $icon . __('Error'), $options);
    }

    public function lapseLabel(?Lapse $lapse): ?string
    {
        if (empty($lapse)) {
            return null;
        }

        if ($lapse->active) {
            return $lapse->name;
        }

        return $lapse->name . ' ' . $this->badge($lapse->getActive());
    }

    public function badge(BadgeInterface $enum, array $options = []): string
    {
        $options = [
            'class' => $enum->color()->badge() . ' ' . ($options['class'] ?? ''),
        ];

        $tag = $options['tag'] ?? 'span';
        unset($options['tag']);

        return $this->Html->tag($tag, $enum->label(), $options);
    }

    public function alertMessage()
    {
        return __('Comuniquese con la coordinación de servicio comunitario para mas información');
    }

    public function control(string $fieldName, array $options = []): string
    {
        $options = array_merge([
            'templates' => [
                'input' => '<div {{attrs}}/>{{text}}</div>',
            ],
            'templateVars' => ['text' => $options['value'] ?? $options['text'] ?? '&nbsp;'],
            'style' => 'height: inherit;',
            'value' => Inflector::humanize($fieldName),
        ], $options);

        unset($options['value']);
        unset($options['text']);

        return $this->Form->control($fieldName, $options);
    }
}
