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

    public $helpers = ['Form'];

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

        if (isset($options['class']) && is_array($options['class'])) {
            $options['class'] = implode(' ', (array)$options['class']);
        }

        $options['class'] = trim(ActionColor::SUBMIT->btn() . ' ' . ($options['class'] ?? ''));

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
        ], $options);

        if (isset($options['class']) && is_array($options['class'])) {
            $options['class'] = implode(' ', (array)$options['class']);
        }

        $options['class'] = trim(ActionColor::VALIDATE->btn() . ' ' . ($options['class'] ?? ''));

        return $this->Form->button($title, $options);
    }
}
