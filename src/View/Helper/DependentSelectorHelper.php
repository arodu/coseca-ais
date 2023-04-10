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
        'allowDuplicateScript' => false,
    ];

    public $helpers = ['Form', 'Html'];

    private $isDuplicated = false;

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
    document.addEventListener('DOMContentLoaded', function() {
        function loadSelect(currentSelect, options) {
            currentSelect.innerHTML = '';
            const emptyOption = document.createElement('option');
            emptyOption.text = '{{empty}}';
            emptyOption.value = '';
            currentSelect.add(emptyOption);

            Object.entries(options).forEach(([key, value]) => {
                const option = document.createElement('option');
                option.value = key;
                option.text = value;
                currentSelect.add(option);
            });
    
            const target = document.querySelector(currentSelect.dataset.target);
            if (target) {
                loadSelect(target, []);
            }
        }
    
        document.querySelectorAll('{{selectorName}}').forEach(function(select) {
            select.addEventListener('change', function() {
                const value = this.value;
                const target = document.querySelector(this.dataset.target);
        
                if (!target) {
                    return;
                }

                loadSelect(target, []);

                if (value === '') {
                    return;
                }
        
                const url = target.dataset.url + '/' + value;
        
                fetch(url, {
                    method: '{{type}}'
                })
                .then(response => response.json())
                .then(data => loadSelect(target, data.data))
                .catch(() => loadSelect(target, []));
            });
        });
    });
    SCRIPT_TEMPLATE;
    /**
     * @param string|null $selectorName
     * @param array<string, mixed> $options
     * @return string|null
     */
    public function script(?string $selectorName = null, array $options = []): ?string
    {
        if ($this->isDuplicated && !$this->getConfig('allowDuplicateScript')) {
            return null;
        }

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

        $this->isDuplicated = true;

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
            $class = trim(implode(' ', $class));
        }

        $class = $class ?? '';
        $class .= ' ' . $this->getConfig('selectorName');

        return $class;
    }
}
