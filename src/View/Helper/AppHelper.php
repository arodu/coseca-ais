<?php
declare(strict_types=1);

namespace App\View\Helper;

use App\Model\Entity\Lapse;
use App\Model\Entity\Tenant;
use App\Utility\Calc;
use Cake\Utility\Inflector;
use Cake\View\Helper;
use CakeLteTools\Enum\BadgeInterface;
use CakeLteTools\Enum\Color;
use CakeLteTools\Utility\FaIcon;
use CakeLteTools\Utility\Html;
use Exception;

/**
 * App helper
 *
 * @property \Cake\View\Helper\HtmlHelper $Html
 * @property \Cake\View\Helper\FormHelper $Form
 */
class AppHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected array $_defaultConfig = [];

    public array $helpers = ['Html', 'Form'];

    /**
     * @param array $options
     * @return string
     */
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
     * @param string $prefix
     * @return string
     */
    public function progressBarColor(float $percent, string $prefix = 'bg'): string
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
     * @return string
     */
    public function progressBar(float $completed, ?float $total = null): string
    {
        $percent = Calc::percentHoursCompleted($completed, $total);

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

    /**
     * @param string|null $tooltip
     * @return string
     */
    public function error(?string $tooltip = null): string
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

    /**
     * @param \App\Model\Entity\Lapse|null $lapse
     * @return string|null
     */
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

    /**
     * @param \CakeLteTools\Enum\BadgeInterface $enum
     * @param array $options
     * @return string
     */
    public function badge(?BadgeInterface $enum, array $options = []): string
    {
        if (empty($enum)) {
            return $this->nan($options);
        }

        $options = array_merge([
            'tag' => 'span',
        ], $options);

        $options['class'] = Html::classToString([$enum->color()->badge(), $options['class'] ?? null]);
        $tag = $options['tag'] ?? 'span';
        unset($options['tag']);

        return $this->Html->tag($tag, $enum->label(), $options);
    }

    /**
     * @return string
     */
    public function alertMessage(): string
    {
        return __('Comuniquese con la coordinación de servicio comunitario para mas información');
    }

    /**
     * @param string $fieldName
     * @param array $options
     * @return string
     */
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

    /**
     * @param int $month
     * @return string
     */
    public function month(int $month): string
    {
        return match ($month) {
            1 => __('Enero'),
            2 => __('Febrero'),
            3 => __('Marzo'),
            4 => __('Abril'),
            5 => __('Mayo'),
            6 => __('Junio'),
            7 => __('Julio'),
            8 => __('Agosto'),
            9 => __('Septiembre'),
            10 => __('Octubre'),
            11 => __('Noviembre'),
            12 => __('Diciembre'),
            default => __('NaN'),
        };
    }

    /**
     * @param bool $bool
     * @return string
     */
    public function yn(bool $bool): string
    {
        return $bool ? __('Si') : __('No');
    }

    /**
     * @param \App\Model\Entity\Tenant $tenant
     * @return string
     */
    public function tenant(Tenant $tenant): string
    {
        if (empty($tenant->program)) {
            throw new Exception('Tenant program is empty');
        }

        return __(
            '{0} / {1} / {2}',
            $tenant->program->area_label,
            $this->Html->link($tenant->program->name, ['controller' => 'Tenants', 'action' => 'viewProgram', $tenant->program_id]),
            $this->Html->link($tenant->name, ['controller' => 'Tenants', 'action' => 'view', $tenant->id]),
        );
    }
}
