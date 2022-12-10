<?php

declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * BulkAction helper
 */
class BulkActionHelper extends Helper
{
    public $helpers = ['Form'];

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
    ];


    public function scripts()
    {
    }

    /**
     * @param string|null $type
     * @param string|null $item_id
     * @return string|null
     */
    public function checkbox(string $type = self::TYPE_ALL, ?string $item_id = null, array $options = []): ?string
    {
        $fieldName = $this->getConfig('fieldNameAll');
        if ($type == self::TYPE_ITEM) {
            $fieldName = $this->getConfig('fieldNameItem') . '.' . $item_id;
        }

        $options = array_merge([
            'type' => 'checkbox',
            'label' => false,
            'hiddenField' => false,
        ], $options);

        return $this->Form->control($fieldName, $options);
    }

    public function selectActions($options)
    {
        $options = array_merge([
            'label' => false,
            'empty' => true,
            'options' => [],
            'required' => true,
        ], $options);

        return $this->Form->control($this->getConfig('fieldNameSelectAction'), $options) 
            . $this->Form->button(__('Submit'));
    }
}


// public function control(string $fieldName, array $options = []): string