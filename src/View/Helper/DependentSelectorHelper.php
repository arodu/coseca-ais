<?php

declare(strict_types=1);

namespace App\View\Helper;

use Cake\Utility\Text;
use Cake\View\Helper;
use Cake\View\View;

use function PHPSTORM_META\type;

/**
 * DependentSelector helper
 */
class DependentSelectorHelper extends Helper
{
    /**
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [
        'selectorName' => 'dependent-selector',
        'empty' => null,
    ];

    public $helpers = ['Form', 'Html'];

    /**
     * @inheritDoc
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        if ($this->getConfig('empty') === null) {
            $this->setConfig('empty', __('Select an option'));
        }
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
     * @param string|null $selectorName
     * @param array<string, mixed> $options
     * @return string|null
     */
    public function script(?string $selectorName = null, array $options = []): ?string
    {
        $block = $options['block'] ?? true;
        unset($options['block']);

        $selectorName = $selectorName ?: '.' . $this->getConfig('selectorName');

        $script = Text::insert($this->selectDependentTemplate, [
            'selectorName' => $selectorName,
            'type' => $options['type'] ?? 'GET',
            'empty' => $options['empty'] ?? $this->getConfig('empty'),
        ], [
            'before' => '{{',
            'after' => '}}',
        ]);

        return $this->Html->scriptBlock($script, ['block' => $block]);
    }

    public function control(string $fieldName, array $options = []): string
    {
        $options['class'] = $this->handleCssClass($options['class'] ?? null);

        $options = array_merge([
            'type' => 'select',
            'empty' => $this->getConfig('empty'),
            'options' => [],
            'data-target' => null,
            'data-url' => null,
        ], $options);

        return $this->Form->control($fieldName, $options);
    }

    protected function handleCssClass($class): string
    {
        if (is_array($class)) {
            $class = implode(' ', $class);
        }

        $class = $class ?? '';
        $class .= ' ' . $this->getConfig('selectorName');

        return $class;
    }
}
