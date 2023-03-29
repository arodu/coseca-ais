<?php

declare(strict_types=1);

namespace App\View\Helper;

use App\Enum\ActionColor;
use Cake\View\Helper;
use Cake\View\View;

/**
 * AppForm helper
 */
class AppFormHelper extends Helper
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
    public function buttonSave(array $options = []): string
    {
        $title = $options['label'] ?? __('Guardar');
        unset($options['label']);

        $options = array_merge([
            'name' => 'action',
            'value' => 'save',
        ], $options);

        $options['class'] = $this->prepareClass($options['class'] ?? '', ActionColor::SUBMIT);

        return $this->Form->button($title, $options);
    }

    /**
     * @param array<string, mixed> $options
     * @return string
     */
    public function buttonValidate(array $options = []): string
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

    public function buttonCancel(array $options = []): string
    {
        if (empty($options['url'])) {
            throw new \InvalidArgumentException('url is required');
        }

        $url = $options['url'];
        unset($options['url']);

        $title = $options['label'] ?? __('Cancelar');
        unset($options['label']);

        $options['class'] = $this->prepareClass($options['class'] ?? '', ActionColor::CANCEL);

        return $this->Html->link($title, $url, $options);
    }

    protected function prepareClass(array|string $class, ActionColor $actionColor): string
    {
        if (is_array($class)) {
            $class = implode(' ', $class);
        }

        return $actionColor->btn($class);
    }
}
