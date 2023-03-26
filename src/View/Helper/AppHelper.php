<?php

declare(strict_types=1);

namespace App\View\Helper;

use App\Enum\BadgeInterface;
use App\Enum\Color;
use App\Model\Entity\Lapse;
use App\Utility\FaIcon;
use Cake\Utility\Text;
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
     * @param integer $completed
     * @param integer $total
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
     * @param integer $completed
     * @param integer $total
     * @return string
     */
    public function progressBar(float $completed, float $total): string
    {
        $percent = $this->progressBarCalc($completed, $total, 0);

        $output = '<div class="progress progress-sm" title="' . __('{0} horas', $completed) . '">'
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
        ;
    }

    protected $selectDependentTemplate = <<<SCRIPT_TEMPLATE
    $(function () {
        function loadSelect(currentSelect, options) {
            $(currentSelect).empty();
            $(currentSelect).append('<option value="">{{empty}}</option>');
            $.each(options, function (key, value) {
                $(currentSelect).append('<option value="' + key + '">' + value + '</option>');
            });

            const target = $(currentSelect).data('target');
            if (target) {
                loadSelect(target, []);
            }
        }

        $('{{selectorName}}').on('change', function() {
            const value = $(this).val();
            const target = $(this).data('target');

            if (value === '') {
                loadSelect(target, []);
                return;
            }

            const url = $(target).data('url') + '/' + value;

            $.ajax({
                url: url,
                type: '{{type}}',
                beforeSend: function() {
                    loadSelect(target, []);
                },
                success: function(data) {
                    loadSelect(target, data['data']);
                },
                error: function() {
                    loadSelect(target, []);
                },
            });
        });
    })
    SCRIPT_TEMPLATE;

    /**
     * @param string $selectorName
     * @param array<string, mixed> $options
     * @return string|null
     */
    public function selectDependentScript(string $selectorName = '.select-dependent', array $options = []): ?string
    {
        $script = Text::insert($this->selectDependentTemplate, [
            'selectorName' => $selectorName,
            'type' => $options['type'] ?? 'GET',
            'empty' => $options['empty'] ?? __('Seleccione una opción'),
        ], [
            'before' => '{{',
            'after' => '}}',
        ]);

        return $this->Html->scriptBlock($script, ['block' => true]);
    }

    public function badge(BadgeInterface $enum, array $options = []): string
    {
        $options = [
            'class' => $enum->color()->cssClass('badge') . ' ' . ($options['class'] ?? ''),
        ];

        $tag = $options['tag'] ?? 'span';
        unset($options['tag']);

        return $this->Html->tag($tag, $enum->label(), $options);
    }
}
