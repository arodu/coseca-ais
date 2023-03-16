<?php
namespace App\View\Widget;

use Cake\View\Form\ContextInterface;
use Cake\View\StringTemplate;
use Cake\View\Widget\WidgetInterface;

class DependentSelectorWidget implements WidgetInterface
{
    protected $_templates;

    public function __construct(StringTemplate $templates)
    {
        $this->_templates = $templates;
    }

    public function render(array $data, ContextInterface $context): string
    {
        //debug($data);
        //debug($context);


        return $this->_templates->format('select', [
            'name' => $data['name'],
            'attrs' => $this->_templates->formatAttributes($data, ['name'])
        ]);
    }

    public function secureFields(array $data): array
    {
        return [$data['name']];
    }
}
