<?php
declare(strict_types=1);

namespace App\View\Helper;

use App\Enum\ActionColor;
use Cake\View\Helper;
use CakeLteTools\Utility\FaIcon;

/**
 * Button helper
 */
class ButtonHelper extends Helper
{
    public const ICON_POSITION_LEFT = 'left';
    public const ICON_POSITION_RIGHT = 'right';

    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [
        'icon' => [
            'link' => 'default',
            'save' => 'save',
            'validate' => 'validate',
            'export' => 'file-csv',
            'search' => 'search',
            'view' => 'view',
            'add' => 'add',
            'edit' => 'edit',
            'delete' => 'delete',
            'back' => 'back',
            'report' => 'report',
            'statistics' => 'chart-bar',
        ],
        'icon_class' => 'fa-fw',
        'icon_position' => self::ICON_POSITION_LEFT, // left, right
    ];

    public $helpers = ['Form', 'Html'];

    /**
     * @param array<string, mixed> $options
     * @return string
     */
    public function link(array $options = []): string
    {
        $this->requireUrl($options);

        if (empty($options['label']) && empty($options['icon'])) {
            $options['icon'] = FaIcon::get($this->getConfig('icon.link'), $this->getConfig('icon_class'));
        }

        if (empty($options['actionColor'])) {
            throw new \InvalidArgumentException('actionColor is required');
        }

        if (isset($options['displayCondition'])) {
            $displayCondition = $options['displayCondition'];
            unset($options['displayCondition']);

            if (is_callable($displayCondition)) {
                $displayCondition = $displayCondition();
            }

            if (!$displayCondition) {
                return '';
            }
        }

        $url = $options['url'];
        unset($options['url']);

        $actionColor = $options['actionColor'];
        unset($options['actionColor']);

        $label = $options['label'] ?: null;
        unset($options['label']);

        $icon = $options['icon'] ?: null;
        unset($options['icon']);

        $icon_position = $options['icon_position'] ?? $this->getConfig('icon_position') ?? self::ICON_POSITION_LEFT;
        unset($options['icon_position']);

        $outline = (bool)$options['outline'] ?? false;
        unset($options['outline']);

        $title = $this->createTitle($label, $icon, $icon_position);

        $options = array_merge([
            'escape' => false,
        ], $options);

        if (!empty($options['class']) && $options['override']) {
        } elseif ($options['icon-link'] ?? false) {
            $options['class'] = trim($actionColor->text() . ' ' . ($options['class'] ?? ''));
            $options['title'] = $options['title'] ?? $label ?? null;
            $title = $icon;
        } else {
            $options['class'] = $this->prepareClass($options['class'] ?? '', $actionColor, $outline);
        }

        if (isset($options['activeCondition'])) {
            $activeCondition = $options['activeCondition'];
            unset($options['activeCondition']);

            if (is_callable($activeCondition)) {
                $activeCondition = (bool)$activeCondition();
            }

            if (!$activeCondition) {
                $options['class'] .= ' disabled';
            }
        }

        return $this->Html->link($title, $url, $options);
    }

    public function postLink(array $options): string
    {
        if (isset($options['displayCondition'])) {
            $displayCondition = $options['displayCondition'];
            unset($options['displayCondition']);

            if (is_callable($displayCondition)) {
                $displayCondition = (bool)$displayCondition();
            }

            if (!$displayCondition) {
                return '';
            }
        }

        $this->requireUrl($options);

        if (empty($options['label']) && empty($options['icon'])) {
            $options['icon'] = FaIcon::get($this->getConfig('icon.link'), $this->getConfig('icon_class'));
        }

        if (empty($options['actionColor'])) {
            throw new \InvalidArgumentException('actionColor is required');
        }

        $url = $options['url'];
        unset($options['url']);

        $title = $this->createTitle($options['label'] ?? null, $options['icon'] ?? null, $options['icon_position'] ?? null);
        unset($options['label']);
        unset($options['icon']);
        unset($options['icon_position']);

        $actionColor = $options['actionColor'];
        unset($options['actionColor']);

        $outline = $options['outline'] ?? false;
        unset($options['outline']);

        $options = array_merge([
            'escape' => false,
        ], $options);

        if (!empty($options['class']) && ($options['override'] ?? false)) {
        } else {
            $options['class'] = $this->prepareClass($options['class'] ?? '', $actionColor, $outline);
        }

        if (isset($options['activeCondition'])) {
            $activeCondition = $options['activeCondition'];
            unset($options['activeCondition']);

            if (is_callable($activeCondition)) {
                $activeCondition = (bool)$activeCondition();
            }

            if (!$activeCondition) {
                $options['class'] .= ' disabled';
            }
        }

        return $this->Form->postLink($title, $url, $options);
    }

    /**
     * @param array<string, mixed> $options
     * @return string
     */
    public function button(array $options = []): string
    {
        if (empty($options['actionColor'])) {
            throw new \InvalidArgumentException('actionColor is required');
        }

        if (empty($options['label']) && empty($options['icon'])) {
            throw new \InvalidArgumentException('label is required');
        }

        if (isset($options['displayCondition'])) {
            $displayCondition = $options['displayCondition'];
            unset($options['displayCondition']);

            if (is_callable($displayCondition)) {
                $displayCondition = $displayCondition();
            }

            if (!$displayCondition) {
                return '';
            }
        }

        $title = $this->createTitle($options['label'] ?? null, $options['icon'] ?? null, $options['icon_position'] ?? null);
        unset($options['label']);
        unset($options['icon']);
        unset($options['icon_position']);

        $actionColor = $options['actionColor'];
        unset($options['actionColor']);

        $outline = $options['outline'] ?? false;
        unset($options['outline']);

        $options = array_merge([
            'escapeTitle' => false,
            'type' => 'submit',
        ], $options);

        if (!empty($options['class']) && ($options['override'] ?? false)) {
        } else {
            $options['class'] = $this->prepareClass($options['class'] ?? '', $actionColor, $outline);
        }

        if (isset($options['activeCondition'])) {
            $activeCondition = $options['activeCondition'];
            unset($options['activeCondition']);

            if (is_callable($activeCondition)) {
                $displayCondition = $activeCondition();
            }

            if (!$activeCondition) {
                $options['disabled'] = 'disabled';
            }
        }

        return $this->Form->button($title, $options);
    }

    /**
     * @param array<string, mixed> $options
     * @return string
     */
    public function save(array $options = []): string
    {
        $options = array_merge([
            'type' => 'submit',
            'name' => 'action',
            'value' => 'save',
            'icon' => FaIcon::get($this->getConfig('icon.save'), $this->getConfig('icon_class')),
            'label' => __('Guardar'),
            'actionColor' => ActionColor::SUBMIT,
        ], $options);

        return $this->button($options);
    }

    /**
     * @param array<string, mixed> $options
     * @return string
     */
    public function validate(array $options = []): string
    {
        $options = array_merge([
            'type' => 'submit',
            'name' => 'action',
            'value' => 'validate',
            'icon' => FaIcon::get($this->getConfig('icon.validate'), $this->getConfig('icon_class')),
            'label' => __('Guardar y Validar'),
            'actionColor' => ActionColor::VALIDATE,
            'confirm' => __('Seguro que desea validar este registro?'),
        ], $options);

        return $this->button($options);
    }

    public function closeModal(array $options = []): string
    {
        $options = array_merge([
            'type' => 'button',
            'data-dismiss' => 'modal',
            'icon' => false,
            'label' => __('Cancelar'),
            'actionColor' => ActionColor::CANCEL,
        ], $options);

        return $this->button($options);
    }

    public function openModal(array $options = []): string
    {
        $options = array_merge([
            'type' => 'button',
            'data-toggle' => 'modal',
            'data-target' => '#modal',
            'icon' => $this->getDefaultIcon(__FUNCTION__),
            'label' => __('Cancelar'),
            'actionColor' => ActionColor::ADD,
        ], $options);

        return $this->button($options);
    }

    /**
     * @param array<string, mixed> $options
     * @return string
     */
    public function export(array $options = []): string
    {
        $options = array_merge([
            'type' => 'submit',
            'name' => 'export',
            'value' => 'csv',
            'icon' => FaIcon::get($this->getConfig('icon.export'), $this->getConfig('icon_class')),
            'label' => __('Exportar'),
            'actionColor' => ActionColor::REPORT,
        ], $options);

        return $this->button($options);
    }

    /**
     * @param array<string, mixed> $options
     * @return string
     */
    public function search(array $options = []): string
    {
        $options = array_merge([
            'type' => 'submit',
            'name' => 'action',
            'value' => 'search',
            'icon' => FaIcon::get($this->getConfig('icon.search'), $this->getConfig('icon_class')),
            'label' => __('Buscar'),
            'actionColor' => ActionColor::SEARCH,
        ], $options);

        return $this->button($options);
    }

    /**
     * @param array<string, mixed> $options
     * @return string
     */
    public function view(array $options = []): string
    {
        $this->requireUrl($options);

        $options = array_merge([
            'icon' => FaIcon::get($this->getConfig('icon.view'), $this->getConfig('icon_class')),
            'label' => false,
            'escape' => false,
            'actionColor' => ActionColor::VIEW,
            'override' => false,
            'outline' => true,
        ], $options);

        return $this->link($options);
    }

    public function report(array $options = []): string
    {
        $this->requireUrl($options);

        $options = array_merge([
            'icon' => FaIcon::get($this->getConfig('icon.report'), $this->getConfig('icon_class')),
            'label' => false,
            'escape' => false,
            'actionColor' => ActionColor::REPORT,
            'override' => false,
            'outline' => false,
            'target' => '_blank',
        ], $options);

        return $this->link($options);
    }

    public function fileReport(array $options = []): string
    {
        $this->requireUrl($options);

        $options = array_merge([
            'icon' => FaIcon::get($this->getConfig('icon.report'), $this->getConfig('icon_class')),
            'label' => false,
            'escape' => false,
            'actionColor' => ActionColor::REPORT,
            'override' => false,
            'outline' => false,
            'target' => '_blank',
        ], $options);

        return $this->link($options);
    }

    public function statistics(array $options = []): string
    {
        $this->requireUrl($options);

        $options = array_merge([
            'icon' => FaIcon::get($this->getConfig('icon.statistics'), $this->getConfig('icon_class')),
            'label' => __('Reportes'),
            'escape' => false,
            'actionColor' => ActionColor::REPORT,
            'override' => false,
            'outline' => false,
        ], $options);

        return $this->link($options);
    }

    /**
     * @param array<string, mixed> $options
     * @return string
     */
    public function add(array $options = []): string
    {
        $options = array_merge([
            'icon' => FaIcon::get($this->getConfig('icon.add'), $this->getConfig('icon_class')),
            'label' => __('Agregar'),
            'escape' => false,
            'actionColor' => ActionColor::ADD,
            'override' => false,
            'outline' => false,
        ], $options);

        return $this->link($options);
    }

    /**
     * @param array<string, mixed> $options
     * @return string
     */
    public function edit(array $options = []): string
    {
        $this->requireUrl($options);

        $options = array_merge([
            'icon' => FaIcon::get($this->getConfig('icon.edit'), $this->getConfig('icon_class')),
            'label' => false,
            'escape' => false,
            'actionColor' => ActionColor::EDIT,
            'override' => false,
            'outline' => false,
        ], $options);

        return $this->link($options);
    }

    /**
     * @param array<string, mixed> $options
     * @return string
     */
    public function delete(array $options = []): string
    {
        $this->requireUrl($options);

        $options = array_merge([
            'icon' => FaIcon::get($this->getConfig('icon.delete'), $this->getConfig('icon_class')),
            'label' => __('Eliminar'),
            'escape' => false,
            'actionColor' => ActionColor::DELETE,
            'override' => false,
            'outline' => false,
            'confirm' => __('Seguro que desea eliminar este registro?'),
        ], $options);

        return $this->postLink($options);
    }

    /**
     * @param array<string, mixed> $options
     * @return string
     */
    public function remove(array $options = []): string
    {
        $this->requireUrl($options);

        $options = array_merge([
            'icon' => $this->getDefaultIcon(__FUNCTION__),
            'label' => __('Eliminar'),
            'escape' => false,
            'actionColor' => ActionColor::DELETE,
            'override' => false,
            'outline' => false,
            'confirm' => __('Seguro que desea eliminar este registro?'),
        ], $options);

        return $this->postLink($options);
    }

    /**
     * @param array<string, mixed> $options
     * @return string
     */
    public function confirm(array $options = []): string
    {
        $this->requireUrl($options);

        $options = array_merge([
            'icon' => FaIcon::get($this->getConfig('icon.edit'), $this->getConfig('icon_class')),
            'label' => false,
            'escape' => false,
            'actionColor' => ActionColor::EDIT,
            'override' => false,
            'outline' => false,
            'confirm' => __('Seguro que desea realizar esta acción?'),
        ], $options);

        return $this->postLink($options);
    }

    /**
     * @param array<string, mixed> $options
     * @return string
     */
    public function cancel(array $options = []): string
    {
        $this->requireUrl($options);

        $options = array_merge([
            'icon' => false,
            'label' => __('Cancelar'),
            'escape' => false,
            'actionColor' => ActionColor::CANCEL,
            'override' => false,
            'outline' => false,
        ], $options);

        return $this->link($options);
    }

    /**
     * @param array<string, mixed> $options
     * @return string
     */
    public function back(array $options = []): string
    {
        return $this->cancel([
            'icon' => FaIcon::get($this->getConfig('icon.back'), $this->getConfig('icon_class')),
            'label' => __('Volver'),
        ]);
    }

    /**
     * @param array|string $class
     * @param \App\Enum\ActionColor $actionColor
     * @param bool $outline
     * @return string
     */
    protected function prepareClass(array|string $class, ActionColor $actionColor, bool $outline = false): string
    {
        if (is_array($class)) {
            $class = trim(implode(' ', $class));
        }

        return $actionColor->btn($class, $outline);
    }

    /**
     * @param string|null $label
     * @param \CakeLteTools\Utility\FaIcon|false|null $icon
     * @return string|null
     */
    protected function createTitle(?string $label = null, $icon = null, $position = null): ?string
    {
        $position = $position ?? $this->getConfig('icon_position');
        if ($position === self::ICON_POSITION_RIGHT) {
            $title = trim($label . ' ' . $icon);
        } else {
            $title = trim($icon . ' ' . $label);
        }

        return $title;
    }

    protected function getDefaultIcon(string $name): FaIcon
    {
        try {
            $name = $this->getConfig('icon.' . $name, $name);

            return FaIcon::get($name, $this->getConfig('icon_class'));
        } catch (\Throwable $th) {
            return FaIcon::get('default', $this->getConfig('icon_class'));
        }
    }

    protected function requireUrl(array $options): void
    {
        if (empty($options['url'])) {
            throw new \InvalidArgumentException('url param is required');
        }
    }
}
