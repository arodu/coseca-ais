<?php

declare(strict_types=1);

namespace App\View\Helper;

use Cake\Utility\Text;
use Cake\View\Helper;
use Cake\View\View;

/**
 * BulkAction helper
 */
class BulkActionHelper extends Helper
{
    public $helpers = ['Form', 'Html'];

    public const TYPE_ALL = 'all';
    public const TYPE_ITEM = 'item';

    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [
        'fieldNameAll' => 'all',
        'fieldNameItem' => 'item',
        'fieldNameSelectAction' => 'action',
        'url' => ['action' => 'bulkAction'],

        'cssClassAll' => 'bulk-all',
        'cssClassItem' => 'bulk-item',
        'selectAction' => 'bulk-action',
        'form' => 'bulk-form',

        'templates' => [
            'confirm' => '{content}',
        ],
    ];

    protected $scriptTemplate = <<<SCRIPT_TEMPLATE
    $(function () {
        $("{{cssClassAll}}").on("change", function() {
            let items = $("{{cssClassItem}}")
            let all = $("{{cssClassAll}}")
            all.prop("indeterminate", false)
            if ($(this).is(":checked")) {
                items.prop("checked", true)
                all.prop("checked", true)
            } else {
                items.prop("checked", false)
                all.prop("checked", false)
            }
        })

        $("{{cssClassItem}}").on("change", function() {
            let all = $("{{cssClassAll}}")
            all.prop("indeterminate", true)
        })
    })
    SCRIPT_TEMPLATE;

    public function scripts()
    {
        $script = Text::insert($this->scriptTemplate, [
            'cssClassAll' => '.' . $this->getConfig('cssClassAll'),
            'cssClassItem' => '.' . $this->getConfig('cssClassItem'),
            'selectAction' => '.' . $this->getConfig('selectAction'),
        ], [
            'before' => '{{',
            'after' => '}}',
        ]);

        return $this->Html->scriptBlock($script, ['block' => true]);
    }

    /**
     * @param string|null $type
     * @param string|null $item_id
     * @return string|null
     */
    public function checkbox(string $type = self::TYPE_ALL, ?string $item_id = null, array $options = []): ?string
    {
        $fieldName = $this->getConfig('fieldNameAll');
        $class = $this->getConfig('cssClassAll');
        if ($type == self::TYPE_ITEM) {
            $fieldName = $this->getConfig('fieldNameItem') . '.' . $item_id;
            $class = $this->getConfig('cssClassItem');
        }

        $options = array_merge([
            'type' => 'checkbox',
            'label' => false,
            'hiddenField' => false,
            'class' => $class,
        ], $options);

        return $this->Form->control($fieldName, $options);
    }

    public function selectActions($actions, array $options = [])
    {
        $options = array_merge([
            'label' => false,
            'empty' => true,
            'required' => true,
            'class' => '',
        ], $options);

        $options['class'] .= ' ' . $this->getConfig('selectAction');

        return $this->Form->select($this->getConfig('fieldNameSelectAction'), $actions, $options);
    }
}
