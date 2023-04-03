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

    /**
     * @param array<string, mixed> $options
     * @return string
     */
    public function link(array $options = []): string
    {
        if (empty($options['url'])) {
            throw new \InvalidArgumentException('url is required');
        }

        if (empty($options['label']) && empty($options['icon'])) {
            $options['icon'] = FaIcon::get('default');
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

    /**
     * @param array<string, mixed> $options
     * @return string
     */
    public function submit(array $options = []): string
    {
        if (empty($options['actionColor'])) {
            throw new \InvalidArgumentException('actionColor is required');
        }

        if (empty($options['label']) && empty($options['icon'])) {
            throw new \InvalidArgumentException('label is required');
        }

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
            'escapeTitle' => false,
            'type' => 'submit',
        ], $options);

        if (!empty($options['class']) && $options['override']) {
        } else {
            $options['class'] = $this->prepareClass($options['class'] ?? '', $actionColor, $outline);
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
            'name' => 'action',
            'value' => 'save',
            'icon' => FaIcon::get('save', 'fa-fw'),
            'label' => __('Guardar'),
            'actionColor' => ActionColor::SUBMIT,
        ], $options);

        return $this->submit($options);
    }

    /**
     * @param array<string, mixed> $options
     * @return string
     */
    public function validate(array $options = []): string
    {
        $options = array_merge([
            'name' => 'action',
            'value' => 'validate',
            'icon' => FaIcon::get('validate', 'fa-fw'),
            'label' => __('Guardar y Validar'),
            'actionColor' => ActionColor::VALIDATE,
            'confirm' => __('Seguro que desea validar este registro?'),
        ], $options);

        return $this->submit($options);
    }

    /**
     * @param array<string, mixed> $options
     * @return string
     */
    public function export(array $options = []): string
    {
        $options = array_merge([
            'name' => 'export',
            'value' => 'csv',
            'icon' => FaIcon::get('file-csv', 'fa-fw'),
            'label' => __('Exportar'),
            'actionColor' => ActionColor::REPORT,
        ], $options);

        return $this->submit($options);
    }

    /**
     * @param array<string, mixed> $options
     * @return string
     */
    public function search(array $options = []): string
    {
        $options = array_merge([
            'name' => 'action',
            'value' => 'search',
            'icon' => FaIcon::get('search', 'fa-fw'),
            'label' => __('Buscar'),
            'actionColor' => ActionColor::SEARCH,
        ], $options);

        return $this->submit($options);
    }

    /**
     * @param array<string, mixed> $options
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

    /**
     * @param array<string, mixed> $options
     * @return string
     */
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

    /**
     * @param array<string, mixed> $options
     * @return string
     */
    public function edit(array $options = []): string
    {
        if (empty($options['url'])) {
            throw new \InvalidArgumentException('url is required');
        }

        $options = array_merge([
            'icon' => FaIcon::get('edit', 'fa-fw'),
            'label' => false,
            'escape' => false,
            'actionColor' => ActionColor::EDIT,
            'override' => false,
            'outline' => true,
        ], $options);

        return $this->link($options);
    }

    public function delete(array $options = []): string
    {
        if (empty($options['url'])) {
            throw new \InvalidArgumentException('url is required');
        }

        $options = array_merge([
            'icon' => FaIcon::get('delete', 'fa-fw'),
            'label' => __('Eliminar'),
            'escape' => false,
            'actionColor' => ActionColor::DELETE,
            'override' => false,
            'outline' => false,
            'confirm' => __('Seguro que desea eliminar este registro?'),
        ], $options);

        return $this->link($options);
    }

    /**
     * @param array<string, mixed> $options
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
     * @param array<string, mixed> $options
     * @return string
     */
    public function back(array $options = []): string
    {
        return $this->cancel([
            'icon' => FaIcon::get('back', 'fa-fw'),
            'label' => __('Volver'),
        ]);
    }

    /**
     * @param array|string $class
     * @param ActionColor $actionColor
     * @param boolean $outline
     * @return string
     */
    protected function prepareClass(array|string $class, ActionColor $actionColor, bool $outline = false): string
    {
        if (is_array($class)) {
            $class = trim(implode(' ', $class));
        }

        return $actionColor->btn($class, $outline);
    }
}
