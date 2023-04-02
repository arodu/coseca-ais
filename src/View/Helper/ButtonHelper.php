<?php

declare(strict_types=1);

namespace App\View\Helper;

use App\Enum\ActionColor;
use App\Utility\FaIcon;
use Cake\View\Helper;
use Cake\View\View;

/**
 * Button helper
 */
class ButtonHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [];

    public $helpers = ['Form', 'Html'];

    public function link(array $options = []): string
    {
        if (empty($options['url'])) {
            throw new \InvalidArgumentException('url is required');
        }

        if (empty($options['label']) && empty($options['icon'])) {
            throw new \InvalidArgumentException('label is required');
        }

        if (empty($options['actionColor'])) {
            throw new \InvalidArgumentException('actionColor is required');
        }

        $url = $options['url'];
        unset($options['url']);

        $title = $options['label'] ?? null;
        unset($options['label']);

        if (!empty($options['icon'])) {
            $title = trim($options['icon'] . ' ' . $title);
            unset($options['icon']);
        }

        $actionColor = $options['actionColor'];
        unset($options['actionColor']);

        $outline = $options['outline'] ?? false;
        unset($options['outline']);

        $options = array_merge([
            'escape' => false,
        ], $options);

        if (!empty($options['class']) && $options['override']) {
        } else {
            $options['class'] = $this->prepareClass($options['class'] ?? '', $actionColor, $outline);
        }

        return $this->Html->link($title, $url, $options);
    }

    public function submit(array $options = []): string
    {
        return '';
    }

    public function save(array $options = []): string
    {
        $title = $options['label'] ?? __('Guardar');
        unset($options['label']);

        $options = array_merge([
            'name' => 'action',
            'value' => 'save',
        ], $options);

        $options['class'] = $this->prepareClass($options['class'] ?? '', ActionColor::SUBMIT, true);

        return $this->Form->button($title, $options);
    }

    /**
     * @param array<string, mixed> $options
     * @return string
     */
    public function validate(array $options = []): string
    {
        $title = $options['label'] ?? __('Guardar y Validar');
        unset($options['label']);

        $options = array_merge([
            'name' => 'action',
            'value' => 'validate',
            'confirm' => __('Seguro que desea validar este registro?'),
        ], $options);

        $options['class'] = $this->prepareClass($options['class'] ?? '', ActionColor::VALIDATE);

        return $this->Form->button($title, $options);
    }

    /**
     * @param array $options
     * @return string
     */
    public function cancel(array $options = []): string
    {
        if (empty($options['url'])) {
            throw new \InvalidArgumentException('url is required');
        }

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
     * @param array $options
     * @return string
     */
    public function view(array $options = []): string
    {
        if (empty($options['url'])) {
            throw new \InvalidArgumentException('url is required');
        }

        $options = array_merge([
            'icon' => FaIcon::get('view', 'fa-fw'),
            'label' => false,
            'escape' => false,
            'actionColor' => ActionColor::VIEW,
            'override' => false,
            'outline' => true,
        ], $options);

        return $this->link($options);
    }

    public function add(array $options = []): string
    {
        $options = array_merge([
            'icon' => FaIcon::get('add', 'fa-fw'),
            'label' => __('Agregar'),
            'escape' => false,
            'actionColor' => ActionColor::ADD,
            'override' => false,
            'outline' => false,
        ], $options);

        return $this->link($options);
    }

    public function edit(array $options = []): string
    {
        return '';
    }

    protected function prepareClass(array|string $class, ActionColor $actionColor, bool $outline = false): string
    {
        if (is_array($class)) {
            $class = trim(implode(' ', $class));
        }

        return $actionColor->btn($class, $outline);
    }
}
