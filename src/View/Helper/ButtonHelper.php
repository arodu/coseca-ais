<?php

declare(strict_types=1);

namespace App\View\Helper;

use App\Enum\ActionColor;
use Cake\Utility\Hash;
use Cake\View\Helper;
use Cake\View\StringTemplateTrait;
use CakeLteTools\Utility\FaIcon;

/**
 * Button helper
 */
class ButtonHelper extends Helper
{
    use StringTemplateTrait;

    public const ICON_POSITION_LEFT = 'left';
    public const ICON_POSITION_RIGHT = 'right';

    public const RENDER_BUTTON = 'button';
    public const RENDER_LINK = 'link';
    public const RENDER_POST_LINK = 'postLink';

    public const ITEM_SAVE = 'save';
    public const ITEM_VALIDATE = 'validate';
    public const ITEM_OPEN_MODAL = 'openModal';
    public const ITEM_CLOSE_MODAL = 'closeModal';
    public const ITEM_CANCEL = 'cancel';
    public const ITEM_BACK = 'back';

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
        'itemDefaultConfig' => [
            'type' => 'button',
            'icon' => 'default',
            'actionColor' => ActionColor::SUBMIT,
            'render' => self::RENDER_BUTTON,
            'icon_position' => self::ICON_POSITION_LEFT, // left, right
        ],

        /** @deprecated */
        'icon_position' => self::ICON_POSITION_LEFT, // left, right
    ];

    /**
     * @var array
     */
    public $helpers = ['Form', 'Html'];


    /**
     * Retrieves the configuration array for a specific item.
     *
     * @param string $itemName The name of the item.
     * @return array The configuration array for the item.
     */
    public function itemConfig(string $itemName): array
    {
        $item = match ($itemName) {
            self::ITEM_SAVE => [
                'type' => 'submit',
                'name' => 'action',
                'value' => 'save',
                'icon' => 'save',
                'actionColor' => ActionColor::SUBMIT,
                'render' => self::RENDER_BUTTON,
                'label' => __('Guardar'),
            ],
            self::ITEM_VALIDATE => [
                'type' => 'submit',
                'name' => 'action',
                'value' => 'validate',
                'icon' => 'validate',
                'actionColor' => ActionColor::VALIDATE,
                'render' => self::RENDER_BUTTON,
                'confirm' => __('Seguro que desea validar este registro?'),
                'label' => __('Guardar y Validar'),
            ],
            self::ITEM_OPEN_MODAL => [
                'type' => 'button',
                'data-toggle' => 'modal',
                'data-target' => '#modal',
                'icon' => 'default',
                'actionColor' => ActionColor::ADD,
                'render' => self::RENDER_BUTTON,
            ],
            self::ITEM_CLOSE_MODAL => [
                'type' => 'button',
                'data-dismiss' => 'modal',
                'icon' => 'default',
                'label' => __('Cerrar'),
                'actionColor' => ActionColor::CANCEL,
                'render' => self::RENDER_BUTTON,
            ],
            self::ITEM_CANCEL => [
                'icon' => null,
                'label' => __('Cancelar'),
                'escape' => false,
                'actionColor' => ActionColor::CANCEL,
                'override' => false,
                'outline' => false,
                'render' => self::RENDER_LINK,
            ],
            self::ITEM_BACK => [
                'icon' => 'back',
                'label' => __('Volver'),
                'escape' => false,
                'actionColor' => ActionColor::CANCEL,
                'override' => false,
                'outline' => false,
                'render' => self::RENDER_LINK,
            ],

            default => [],
        };

        return Hash::merge($this->getConfig('itemDefaultConfig'), $item);
    }

    /**
     * @param array<string, mixed> $options
     * @return string
     */
    public function link(array $options = []): string
    {
        $this->requireParams($options, ['url', 'actionColor']);

        if (empty($options['label']) && empty($options['icon'])) {
            $options['icon'] = FaIcon::get($this->getConfig('icon.link'), $this->getConfig('icon_class'));
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

    /**
     * @param array $options
     * @return string
     */
    public function postLink(array $options): string
    {
        $this->requireParams($options, ['url', 'actionColor']);

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

        if (empty($options['label']) && empty($options['icon'])) {
            $options['icon'] = FaIcon::get($this->getConfig('icon.link'), $this->getConfig('icon_class'));
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
        $this->requireParams($options, ['actionColor']);

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
     * @param string $name
     * @param array $options
     * @return string
     */
    public function get(string $name, array $options = []): string
    {
        $itemConfig = $this->itemConfig($name);
        if ($itemConfig) {
            $options = array_merge($itemConfig, $options);
        }

        if (isset($options['icon']) && !($options['icon'] instanceof FaIcon)) {
            $options['icon'] = FaIcon::get($options['icon'], $this->getConfig('icon_class'));
        }

        $render = $options['render'] ?? self::RENDER_LINK;
        unset($options['render']);

        return $this->{$render}($options);
    }

    protected function requireParams(array $options, array $required): void
    {
        foreach ($required as $param) {
            if (empty($options[$param])) {
                throw new \InvalidArgumentException($param . ' param is required');
            }
        }
    }

    /* *************************************************************************************** */

    /**
     * @param array $options
     * @return void
     * @throws \InvalidArgumentException
     * @deprecated
     */
    protected function requireUrl(array $options): void
    {
        if (empty($options['url'])) {
            throw new \InvalidArgumentException('url param is required');
        }
    }


    /**
     * @param array $options
     * @return string
     * @deprecated
     */
    public function save(array $options = []): string
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated, use `$this->Button->get(self::ITEM_SAVE, $options)` instead', E_USER_DEPRECATED);

        return $this->get(self::ITEM_SAVE, $options);
    }

    /**
     * @param array<string, mixed> $options
     * @return string
     * @deprecated
     */
    public function validate(array $options = []): string
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated, use `$this->Button->get(self::ITEM_VALIDATE, $options)` instead', E_USER_DEPRECATED);

        return $this->get(self::ITEM_VALIDATE, $options);
    }

    /**
     * @param array $options
     * @return string
     */
    public function closeModal(array $options = []): string
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated, use `$this->Button->get(self::ITEM_CLOSE_MODAL, $options)` instead', E_USER_DEPRECATED);

        return $this->get(self::ITEM_CLOSE_MODAL, $options);
    }

    /**
     * @param array $options
     * @return string
     * @deprecated
     */
    public function openModal(array $options = []): string
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated, use `$this->Button->get(self::ITEM_OPEN_MODAL, $options)` instead', E_USER_DEPRECATED);

        return $this->get(self::ITEM_OPEN_MODAL, $options);
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

    /**
     * @param array $options
     * @return string
     */
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

    /**
     * @param array $options
     * @return string
     */
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

    /**
     * @param array $options
     * @return string
     */
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
        trigger_error('Method ' . __METHOD__ . ' is deprecated, use `$this->Button->get(self::ITEM_CANCEL, $options)` instead', E_USER_DEPRECATED);

        return $this->get(self::ITEM_CANCEL, $options);
    }

    /**
     * @param array<string, mixed> $options
     * @return string
     */
    public function back(array $options = []): string
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated, use `$this->Button->get(self::ITEM_BACK, $options)` instead', E_USER_DEPRECATED);

        return $this->get(self::ITEM_BACK, $options);
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
     * @param \CakeLteTools\Utility\FaIcon|null $icon
     * @param string|null $position
     * @return string|null
     */
    protected function createTitle(?string $label = null, ?FaIcon $icon = null, ?string $position = null): ?string
    {
        $position = $position ?? $this->getConfig('icon_position');
        if ($position === self::ICON_POSITION_RIGHT) {
            $title = trim($label . ' ' . $icon);
        } else {
            $title = trim($icon . ' ' . $label);
        }

        return $title;
    }

    /**
     * @param string $name
     * @return \CakeLteTools\Utility\FaIcon
     */
    protected function getDefaultIcon(string $name): FaIcon
    {
        try {
            $name = $this->getConfig('icon.' . $name, $name);

            return FaIcon::get($name, $this->getConfig('icon_class'));
        } catch (\Throwable $th) {
            return FaIcon::get('default', $this->getConfig('icon_class'));
        }
    }
}
