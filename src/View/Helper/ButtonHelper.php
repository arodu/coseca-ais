<?php
declare(strict_types=1);

namespace App\View\Helper;

use App\Enum\ActionColor;
use App\Enum\Button;
use Cake\Utility\Hash;
use Cake\View\Helper;
use Cake\View\StringTemplateTrait;
use CakeLteTools\Utility\FaIcon;

/**
 * Button helper
 *
 * @property \Cake\View\Helper\HtmlHelper $Html
 * @property \Cake\View\Helper\FormHelper $Form
 */
class ButtonHelper extends Helper
{
    use StringTemplateTrait;

    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [
        'icon_class' => 'fa-fw',
        'itemDefaultConfig' => [
            'type' => 'button',
            'icon' => 'default',
            'actionColor' => ActionColor::SUBMIT,
            'render' => Button::RENDER_BUTTON,
            'icon_position' => Button::ICON_POSITION_LEFT, // left, right
        ],

        /** @deprecated */
        'icon_position' => Button::ICON_POSITION_LEFT, // left, right
    ];

    /**
     * @var array
     */
    public $helpers = ['Form', 'Html'];

    /**
     * @param \App\Enum\Button $item
     * @return array
     */
    public function itemConfig(string|Button $item): array
    {
        if (is_string($item)) {
            $item = Button::tryFrom($item);
        }

        $options = Hash::merge($this->getConfig('itemDefaultConfig'), $item?->options() ?? []);

        if (isset($options['icon']) && !($options['icon'] instanceof FaIcon)) {
            $options['icon'] = FaIcon::get($options['icon'], $this->getConfig('icon_class'));
        }

        return $options;
    }

    /**
     * @param array<string, mixed> $options
     * @return string
     */
    public function link(array $options = []): string
    {
        $this->requiredParams($options, ['url', 'actionColor']);

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

        $icon_position = $options['icon_position'] ?? $this->getConfig('icon_position') ?? Button::ICON_POSITION_LEFT;
        unset($options['icon_position']);

        $outline = (bool)($options['outline'] ?? false);
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
        $this->requiredParams($options, ['url', 'actionColor']);

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

        return $this->Form->postLink($title ?? '', $url, $options);
    }

    /**
     * @param array<string, mixed> $options
     * @return string
     */
    public function button(array $options = []): string
    {
        $this->requiredParams($options, ['actionColor']);

        if (empty($options['label']) && empty($options['icon'])) {
            throw new \InvalidArgumentException('label or icon param is required');
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

        return $this->Form->button($title ?? '', $options);
    }

    /**
     * @param string|\App\Enum\Button $item
     * @param array $options
     * @return string
     * @throws \InvalidArgumentException
     */
    public function get(string|Button $item, array $options = []): string
    {
        $itemConfig = $this->itemConfig($item);
        if ($itemConfig) {
            $options = array_merge($itemConfig, $options);
        }

        $render = $options['render'];
        unset($options['render']);

        return match ($render) {
            Button::RENDER_LINK => $this->link($options),
            Button::RENDER_BUTTON => $this->button($options),
            Button::RENDER_POST_LINK => $this->postLink($options),
            default => throw new \InvalidArgumentException('Invalid render method'),
        };
    }

    /**
     * @param array $options
     * @param array $required
     * @return void
     * @throws \InvalidArgumentException
     */
    protected function requiredParams(array $options, array $required): void
    {
        foreach ($required as $param) {
            if (empty($options[$param])) {
                throw new \InvalidArgumentException($param . ' param is required');
            }
        }
    }

    /**
     * @param string $method
     * @param array $params
     * @return string
     * @throws \BadMethodCallException
     */
    public function __call(string $method, array $params): string
    {
        $item = Button::tryFrom($method);
        if (!is_null($item)) {
            return $this->get($item, $params[0] ?? []);
        }

        throw new \BadMethodCallException('Method ' . $method . ' does not exist');
    }

    public function dropdown(array $options = []): string
    {

        $options = Hash::merge([
            'class' => ['btn-sm', 'btn-flat'],
            'group' => [
                'class' => ['ml-2'],
            ],
            'menu' => [
                'class' => ['dropdown-menu-right'],
            ],
            'items' => [],
        ], $options);

        /*
        <div class="btn-group">
            <button type="button" class="btn btn-warning btn-sm btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown">
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu" role="menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
            </div>
        </div>
        */

        debug($options);
        exit;

        $button = $this->Html->tag('button', '', [
            'type' => 'button',
            'class' => 'btn btn-warning btn-sm btn-flat dropdown-toggle dropdown-icon',
            'data-toggle' => 'dropdown',
        ]);

        $items = [];
        foreach ($options['items'] as $item) {
            $items[] = $this->dropdownItem($item);
        }

        $menu = $this->Html->tag('div', implode('', $items), [
            'class' => 'dropdown-menu',
            'role' => 'menu',
        ]);

        $group = $this->Html->tag('div', $button . $menu, ['class' => 'btn-group']);

        return $group;
    }

    protected function dropdownItem($item): string
    {
        if (isset($item['type']) && $item['type'] === 'divider') {
            return $this->Html->tag('div', '', ['class' => 'dropdown-divider']);
        }

        if (isset($item['type']) && $item['type'] === 'header') {
            return $this->Html->tag('h6', $item['label'], ['class' => 'dropdown-header']);
        }

        return $this->Html->link($item['label'], $item['url'], [
            'class' => 'dropdown-item',
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
     * @param \CakeLteTools\Utility\FaIcon|null $icon
     * @param string|null $position
     * @return string|null
     */
    protected function createTitle(?string $label = null, ?FaIcon $icon = null, ?string $position = null): ?string
    {
        $position = $position ?? $this->getConfig('icon_position');
        if ($position === Button::ICON_POSITION_RIGHT) {
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
